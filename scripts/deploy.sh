#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"
ENV_FILE="$ROOT_DIR/deploy.env"
LFTP="${LFTP:-/opt/homebrew/bin/lftp}"

usage() {
  cat <<'EOF'
Upload local files or folders to the production FTP server.

Usage:
  ./scripts/deploy.sh <path> [path...]
  ./scripts/deploy.sh --dry-run <path> [path...]

Examples:
  ./scripts/deploy.sh wp-content/plugins/immobilgolf-helper/elementors/property.php
  ./scripts/deploy.sh wp-content/plugins/immobilgolf-helper/
  ./scripts/deploy.sh portal/application/controllers/Home.php

Notes:
  - Paths are relative to the project root.
  - Folders are mirrored recursively (local -> remote only).
  - Credentials are loaded from deploy.env (not committed to git).
EOF
}

if [[ ! -f "$ENV_FILE" ]]; then
  echo "Missing $ENV_FILE. Copy deploy.env.example to deploy.env and fill in credentials." >&2
  exit 1
fi

# shellcheck disable=SC1090
source "$ENV_FILE"

for var in FTP_HOST FTP_USER FTP_PASS; do
  if [[ -z "${!var:-}" ]]; then
    echo "Missing $var in deploy.env" >&2
    exit 1
  fi
done

FTP_PORT="${FTP_PORT:-21}"
FTP_REMOTE_PATH="${FTP_REMOTE_PATH:-/}"

if ! command -v "$LFTP" >/dev/null 2>&1; then
  echo "lftp not found. Install with: brew install lftp" >&2
  exit 1
fi

DRY_RUN=0
if [[ "${1:-}" == "--dry-run" ]]; then
  DRY_RUN=1
  shift
fi

if [[ $# -lt 1 ]]; then
  usage
  exit 1
fi

write_lftp_script() {
  local script_path="$1"
  cat >"$script_path" <<LFTP
set ftp:passive-mode true
set ftp:ssl-allow false
set net:max-retries 3
open -u ${FTP_USER},'${FTP_PASS}' ${FTP_HOST}
LFTP
}

upload_file() {
  local rel="$1"
  local local_path="$ROOT_DIR/$rel"
  local remote_dir
  remote_dir="$(dirname "$rel")"
  local remote_path="${FTP_REMOTE_PATH%/}/$rel"
  local lftp_script
  lftp_script="$(mktemp)"

  if [[ ! -f "$local_path" ]]; then
    echo "File not found: $rel" >&2
    return 1
  fi

  echo "Upload file: $rel -> $remote_path"
  if [[ "$DRY_RUN" -eq 1 ]]; then
    return 0
  fi

  write_lftp_script "$lftp_script"
  {
    echo "cd ${FTP_REMOTE_PATH%/}"
    if [[ "$remote_dir" != "." ]]; then
      echo "mkdir -p $remote_dir"
      echo "cd $remote_dir"
    fi
    echo "put \"$local_path\""
    echo "bye"
  } >>"$lftp_script"

  "$LFTP" -f "$lftp_script"
  rm -f "$lftp_script"
}

upload_dir() {
  local rel="${1%/}"
  local local_path="$ROOT_DIR/$rel"
  local remote_path="${FTP_REMOTE_PATH%/}/$rel"
  local lftp_script
  lftp_script="$(mktemp)"

  if [[ ! -d "$local_path" ]]; then
    echo "Directory not found: $rel" >&2
    return 1
  fi

  echo "Upload folder: $rel/ -> $remote_path/"
  if [[ "$DRY_RUN" -eq 1 ]]; then
    return 0
  fi

  write_lftp_script "$lftp_script"
  {
    echo "set mirror:parallel-transfer-count 4"
    echo "lcd \"$local_path\""
    echo "cd ${FTP_REMOTE_PATH%/}/$rel"
    echo "mirror -R --verbose --parallel=4 ."
    echo "bye"
  } >>"$lftp_script"

  "$LFTP" -f "$lftp_script"
  rm -f "$lftp_script"
}

for target in "$@"; do
  target="${target#./}"
  if [[ "$target" == /* ]]; then
    echo "Use paths relative to project root: $target" >&2
    exit 1
  fi

  if [[ -f "$ROOT_DIR/$target" ]]; then
    upload_file "$target"
  elif [[ -d "$ROOT_DIR/$target" ]]; then
    upload_dir "$target"
  else
    echo "Path not found: $target" >&2
    exit 1
  fi
done

echo "Deploy complete."
