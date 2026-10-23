function custom_number_format(val) {
  return val.toFixed(2);
}
(function ($) {
  "use strict";
  // Create by Nguyen Duc Viet

  $(document).ready(function () {
    if ($(".sw_scale_range").length) {
      $(".sw_scale_range").each(function () {
        var th_scale = $(this);
        var th_scale_id = $(this).attr("id");
        var conf_min = "0";
        var conf_max = "100000";
        var conf_sufix = "";
        var conf_prefix = "";
        var conf_infinity = "";
        var conf_predifinedMin = "";
        var conf_predifinedMax = "";

        if (th_scale.find(".config-range").length) {
          var $config = th_scale.find(".config-range");
          conf_min = $config.attr("data-min") || 0;
          conf_max = $config.attr("data-max") || "";
          conf_sufix = $config.attr("data-sufix") || "";
          conf_prefix = $config.attr("data-prefix") || "";
          conf_infinity = $config.attr("data-infinity") || "false";
          conf_predifinedMin = $config.attr("data-predifinedMin") || "";
          conf_predifinedMax = $config.attr("data-predifinedMax") || "";
        }
        scale_range(
          "#" + th_scale_id,
          conf_min,
          conf_max,
          conf_prefix,
          conf_sufix,
          conf_infinity,
          conf_predifinedMin,
          conf_predifinedMax
        );
      });
    }
    if ($('[autocomplete="off"]').length) {
      if (navigator.userAgent.toLowerCase().indexOf("firefox") < 0) {
        $('[autocomplete="off"]').attr("autocomplete", "nope");
      }
    }
  });
})(jQuery);

function scale_range(
  object,
  min,
  max,
  prefix,
  sufix,
  infinity,
  predifinedMin,
  predifinedMax,
  direction
) {
  if (typeof object == "undefined") return false;
  if (typeof min == "undefined" || min == "") var min = 0;
  if (typeof max == "undefined" || max == "") return false;
  if (typeof prefix == "undefined" || prefix == "") var prefix = "";
  if (typeof sufix == "undefined" || sufix == "") var sufix = "";
  if (typeof infinity === "infinity" || infinity == "") var infinity = true;
  if (typeof direction == "undefined" || direction == "") var direction = "ltr";
  if (infinity == "false") infinity = false;

  var $ = jQuery;
  if (typeof predifinedMin == "undefined" || predifinedMin == "") {
    var predifinedMin = min || 0;
    predifinedMin -= 10;
  }
  if (typeof predifinedMax == "undefined" || predifinedMax == "") {
    var predifinedMax = max || 100000;
    predifinedMax += 10;
  }

  /* errors */

  if (!$(object + " .value-min").length || !$(object + " .value-max").length) {
    console.log("Scale range: missing input min or max");
    return false;
  }

  var r = 0;
  if (infinity) {
    r = 10;
  }

  if ($(object + " .nonlinear").length) {
    var nonLinearSlider = document.querySelector(object + " .nonlinear");
    noUiSlider.create(nonLinearSlider, {
      connect: true,
      behaviour: "tap",
      direction: direction,
      start: [predifinedMin, predifinedMax],
      range: {
        min: [parseInt(min) - r],
        max: [parseInt(max) + r],
      },
    });

    var nodes = [
      document.querySelector(object + " .nonlinear-min"), // 0
      document.querySelector(object + " .nonlinear-max"), // 1
    ];

    var inputs = [
      document.querySelector(object + " .value-min"), // 0
      document.querySelector(object + " .value-max"), // 1
    ];

    // Display the slider value and how far the handle moved

    var noUiSlider_ini = 0;

    nonLinearSlider.noUiSlider.on(
      "update",
      function (values, handle, unencoded, isTap, positions) {
        noUiSlider_ini++;

        if (parseInt(values[handle]) > max && infinity) {
          nodes[handle].innerHTML =
            prefix + selio_number_format(parseInt(max)) + sufix + "+";
        } else if (parseInt(values[handle]) < min && infinity) {
          nodes[handle].innerHTML =
            prefix + selio_number_format(parseInt(min)) + sufix + "-";
        } else
          nodes[handle].innerHTML =
            prefix + selio_number_format(parseInt(values[handle])) + sufix;

        if (parseInt(values[handle]) > max && infinity) {
          inputs[handle].value = "";
        } else if (parseInt(values[handle]) < min && infinity) {
          inputs[handle].value = "";
        } else if (noUiSlider_ini > 2)
          inputs[handle].value = parseInt(values[handle]).toFixed();

        if (noUiSlider_ini > 2 && $(object + " .value-max").val() == "") {
          $(object + " .value-max").val(predifinedMax);
        }

        $(object + " .value-min, " + object + " .value-max").trigger("change");
      }
    );
  }
}

function selio_number_format(number, format) {
  if (typeof format == "undefined") var format = true;

  if (format) return new Intl.NumberFormat("de-DE").format(number.toFixed());
  else return number.toFixed();
}

(function ($) {
  "use strict";

  var MSG_REQUIRED = "Il campo è obbligatorio.";
  var MSG_EMAIL = "L'indirizzo e-mail inserito non è valido.";
  var MSG_PASSWORD = "Le password non coincidono.";
  var MSG_PASSWORD_LEN = "La password deve contenere almeno 6 caratteri.";

  function clearValidation($form) {
    $form.find(".immobilgolf-auth-form__not-valid-tip").remove();
    $form.find(".is-not-valid").removeClass("is-not-valid");
    $form.removeClass("is-invalid");
  }

  function markInvalid($field, message) {
    var $wrap = $field.closest(".immobilgolf-auth-form__control-wrap");
    if (!$wrap.length) {
      $wrap = $field.parent();
    }
    $field.addClass("is-not-valid");
    $wrap.find(".immobilgolf-auth-form__not-valid-tip").remove();
    $wrap.append(
      $("<span>", {
        class: "immobilgolf-auth-form__not-valid-tip",
        role: "alert",
        text: message,
      })
    );
  }

  function validateAuthForm($form) {
    clearValidation($form);
    var valid = true;
    var type = $form.data("form");

    $form.find("[required]").each(function () {
      var $field = $(this);
      var value = $field.is(":checkbox")
        ? $field.is(":checked")
        : $.trim(String($field.val() || ""));

      if (!value) {
        markInvalid($field, MSG_REQUIRED);
        valid = false;
      }
    });

    var $email = $form.find('input[type="email"][name="email"]');
    if ($email.length && $.trim($email.val())) {
      var emailVal = $.trim($email.val());
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
        markInvalid($email, MSG_EMAIL);
        valid = false;
      }
    }

    if (type === "register") {
      var $pwd = $form.find('[name="password"]');
      var $pwd2 = $form.find('[name="password_confirm"]');
      var pwd = $pwd.val() || "";
      var pwd2 = $pwd2.val() || "";

      if (pwd && pwd.length < 6) {
        markInvalid($pwd, MSG_PASSWORD_LEN);
        valid = false;
      }
      if (pwd && pwd2 && pwd !== pwd2) {
        markInvalid($pwd2, MSG_PASSWORD);
        valid = false;
      }
    }

    if (!valid) {
      $form.addClass("is-invalid");
      var $first = $form.find(".is-not-valid").first();
      if ($first.length) {
        $("html, body").animate({ scrollTop: $first.offset().top - 120 }, 300);
      }
    }

    return valid;
  }

  function revealCard($wrap) {
    $wrap.find(".immobilgolf-auth-form__loading").remove();
  }

  function showLoggedIn($wrap, data) {
    $wrap.addClass("is-logged-in");
    $wrap.find(".immobilgolf-auth-form__guest").remove();
    $wrap.find(".immobilgolf-auth-form__logged").removeAttr("hidden");
    $wrap.find(".immobilgolf-auth-form__logged-name").text(data.name || "");
    $wrap.find(".immobilgolf-auth-form__admin-btn").attr("href", data.admin_url || "#");
    $wrap.find(".immobilgolf-auth-form__logout-btn").attr("href", data.logout_url || "#");
    revealCard($wrap);
  }

  function showGuest($wrap) {
    $wrap.removeClass("is-logged-in");
    $wrap.find(".immobilgolf-auth-form__logged").attr("hidden", true);
    $wrap.find(".immobilgolf-auth-form__guest").removeAttr("hidden");
    revealCard($wrap);
  }

  $(document).on("click", ".immobilgolf-auth-form__logout-btn", function (e) {
    e.preventDefault();

    var $wrap = $(this).closest(".immobilgolf-auth-form");
    var logoutUrl =
      $wrap.data("portal-logout-url") ||
      (window.immobilgolfAuth && immobilgolfAuth.portalLogoutUrl) ||
      "https://portal.immobilgolf.com/index.php/api/logout_form/it";
    var redirectUrl =
      $wrap.data("logout-redirect") ||
      "https://immobilgolf.com/home-tee-time/";

    $.ajax({
      url: logoutUrl,
      type: "POST",
      dataType: "json",
      xhrFields: { withCredentials: true },
      crossDomain: true,
    }).always(function () {
      window.location.href = redirectUrl;
    });
  });

  function checkPortalLogin($wrap) {
    var checkUrl =
      $wrap.data("portal-check-url") ||
      (window.immobilgolfAuth && immobilgolfAuth.portalCheckUrl) ||
      "https://portal.immobilgolf.com/index.php/api/check_login/it";

    return $.ajax({
      url: checkUrl,
      type: "GET",
      dataType: "json",
      xhrFields: { withCredentials: true },
      crossDomain: true,
      cache: false,
    }).done(function (res) {
      if (res && res.license_expired && (res.licenses_url || res.token)) {
        showGuest($wrap);
        openLicensesModal($wrap, res.licenses_url || null);
        return;
      }
      if (res && res.logged_in) {
        showLoggedIn($wrap, res);
      } else {
        showGuest($wrap);
      }
    });
  }

  $(function () {
    $(".immobilgolf-auth-form").each(function () {
      checkPortalLogin($(this));
    });
  });

  $(document).on("click", ".immobilgolf-auth-form__tab", function () {
    var $wrap = $(this).closest(".immobilgolf-auth-form");
    var tab = $(this).data("tab");

    $wrap.find(".immobilgolf-auth-form__tab").removeClass("is-active");
    $(this).addClass("is-active");
    $wrap.find(".immobilgolf-auth-form__panel").removeClass("is-active");
    $wrap.find('.immobilgolf-auth-form__panel[data-panel="' + tab + '"]').addClass("is-active");
  });

  $(document).on("click", "[data-password-toggle]", function (e) {
    e.preventDefault();
    var $btn = $(this);
    var $wrap = $btn.closest(".immobilgolf-auth-form__control-wrap--password");
    var $input = $wrap.find('input[type="password"], input[type="text"]').first();
    if (!$input.length) {
      return;
    }

    var showing = $input.attr("type") === "text";
    $input.attr("type", showing ? "password" : "text");
    $btn.attr("aria-pressed", showing ? "false" : "true");
    $btn.attr("aria-label", showing ? "Mostra password" : "Nascondi password");
    $btn.find(".immobilgolf-auth-form__password-toggle-icon--show").prop("hidden", !showing);
    $btn.find(".immobilgolf-auth-form__password-toggle-icon--hide").prop("hidden", showing);
  });

  $(document).on(
    "input change",
    ".immobilgolf-auth-form__form .is-not-valid",
    function () {
      var $field = $(this);
      var $wrap = $field.closest(".immobilgolf-auth-form__control-wrap");
      $field.removeClass("is-not-valid");
      $wrap.find(".immobilgolf-auth-form__not-valid-tip").remove();
    }
  );

  $(document).on("submit", ".immobilgolf-auth-form__form", function (e) {
    e.preventDefault();

    var $form = $(this);
    var type = $form.data("form");
    var auth = $form.data("auth") || "wp";
    var $btn = $form.find(".immobilgolf-auth-form__submit");
    var $msg = $form.find(".immobilgolf-auth-form__message");
    var ajaxUrl =
      (window.immobilgolfAuth && immobilgolfAuth.ajaxUrl) ||
      "/wp-admin/admin-ajax.php";

    if (!validateAuthForm($form)) {
      $msg
        .removeAttr("hidden")
        .removeClass("is-success")
        .addClass("is-error")
        .text("Uno o più campi contengono un errore. Controlla e riprova.");
      return;
    }

    if ($.trim($form.find('[name="website"]').val() || "")) {
      return;
    }

    $btn.prop("disabled", true).addClass("is-loading");
    $msg.attr("hidden", true).removeClass("is-success is-error").text("");

    if (type === "login" && auth === "portal") {
      var portalUrl =
        $form.data("portal-url") ||
        (window.immobilgolfAuth && immobilgolfAuth.portalLoginUrl) ||
        "https://portal.immobilgolf.com/index.php/api/login_form/it";
      var customRedirect = $.trim($form.find('[name="redirect"]').val() || "");
      var successText =
        $.trim($form.find('[name="success_message"]').val() || "") ||
        "Accesso effettuato correttamente.";
      var $wrap = $form.closest(".immobilgolf-auth-form");

      $.ajax({
        url: portalUrl,
        type: "POST",
        dataType: "json",
        xhrFields: { withCredentials: true },
        crossDomain: true,
        data: {
          username: $form.find('[name="username"]').val(),
          password: $form.find('[name="password"]').val(),
        },
      })
        .done(function (res) {
          if (res && res.license_expired && (res.licenses_url || res.token)) {
            $msg
              .removeAttr("hidden")
              .removeClass("is-success")
              .addClass("is-error")
              .text(
                res.message ||
                  "La licenza è scaduta. Devi rinnovarla per continuare."
              );
            openLicensesModal(
              $wrap,
              res.licenses_url || null
            );
            return;
          }

          if (res && res.success) {
            $msg
              .removeAttr("hidden")
              .removeClass("is-error")
              .addClass("is-success")
              .text(successText);

            if (customRedirect) {
              window.location.href = customRedirect;
              return;
            }

            // Stay on page and show logged-in buttons
            checkPortalLogin($wrap).always(function () {
              if (res.redirect && !$wrap.hasClass("is-logged-in")) {
                window.location.href = res.redirect;
              }
            });
            return;
          }

          var errHtml = (res && res.errors) || "";
          var errText = $("<div>").html(errHtml).text().replace(/\s+/g, " ").trim();
          $msg
            .removeAttr("hidden")
            .removeClass("is-success")
            .addClass("is-error")
            .text(errText || "Credenziali non valide.");
        })
        .fail(function () {
          $msg
            .removeAttr("hidden")
            .removeClass("is-success")
            .addClass("is-error")
            .text("Si è verificato un errore. Riprova più tardi.");
        })
        .always(function () {
          $btn.prop("disabled", false).removeClass("is-loading");
        });
      return;
    }

    // Register: validate + create pending on Portal only (no WordPress account check).
    if (type === "register") {
      var pendingUrl =
        ($form.closest(".immobilgolf-auth-form").data("portal-pending-url")) ||
        (window.immobilgolfAuth && immobilgolfAuth.portalPendingUrl) ||
        "https://portal.immobilgolf.com/index.php/api/registration_pending/it";

      $.ajax({
        url: pendingUrl,
        type: "POST",
        dataType: "json",
        xhrFields: { withCredentials: true },
        crossDomain: true,
        data: {
          name: $form.find('[name="name"]').val(),
          surname: $form.find('[name="surname"]').val(),
          email: $form.find('[name="email"]').val(),
          phone: $form.find('[name="phone"]').val(),
          password: $form.find('[name="password"]').val(),
          tipo: $form.find('[name="tipo"]').val(),
          provincia: $form.find('[name="provincia"]').val(),
          club: $form.find('[name="club"]').val(),
          address: $form.find('[name="address"]').val(),
          city: $form.find('[name="city"]').val(),
          postal_code: $form.find('[name="postal_code"]').val(),
          codice_fiscale: $form.find('[name="codice_fiscale"]').val(),
        },
      })
        .done(function (res) {
          if (res && res.success && res.token) {
            // Free registration period: account already created — claim session, no popup.
            if (res.free_register || res.paid) {
              $msg
                .removeAttr("hidden")
                .removeClass("is-error")
                .addClass("is-success")
                .text("Registrazione gratuita in corso…");
              finishRegistrationReturn(res.token);
              return;
            }

            $msg
              .removeAttr("hidden")
              .removeClass("is-error")
              .addClass("is-success")
              .text("Scegli una licenza per completare la registrazione.");
            openLicensesModal(
              $form.closest(".immobilgolf-auth-form"),
              res.licenses_url || null
            );
            return;
          }

          var err = (res && res.message) || "Impossibile avviare la registrazione.";
          $msg
            .removeAttr("hidden")
            .removeClass("is-success")
            .addClass("is-error")
            .text(err);
        })
        .fail(function () {
          $msg
            .removeAttr("hidden")
            .removeClass("is-success")
            .addClass("is-error")
            .text("Si è verificato un errore. Riprova più tardi.");
        })
        .always(function () {
          $btn.prop("disabled", false).removeClass("is-loading");
        });
      return;
    }

    $.ajax({
      url: ajaxUrl,
      type: "POST",
      dataType: "json",
      data: $form.serialize(),
    })
      .done(function (res) {
        var text =
          (res && res.data && res.data.message) ||
          (res && res.success ? "OK" : "Si è verificato un errore.");

        $msg
          .removeAttr("hidden")
          .toggleClass("is-success", !!(res && res.success))
          .toggleClass("is-error", !(res && res.success))
          .text(text);

        if (res && res.success) {
          if (res.data && res.data.redirect) {
            window.location.href = res.data.redirect;
          } else if (type === "login") {
            window.location.reload();
          }
        }
      })
      .fail(function (xhr) {
        var text =
          (xhr.responseJSON &&
            xhr.responseJSON.data &&
            xhr.responseJSON.data.message) ||
          "Si è verificato un errore. Riprova più tardi.";
        $msg
          .removeAttr("hidden")
          .removeClass("is-success")
          .addClass("is-error")
          .text(text);
      })
      .always(function () {
        $btn.prop("disabled", false).removeClass("is-loading");
      });
  });

  function openLicensesModal($wrap, licensesUrl) {
    var $modal = $wrap.find(".immobilgolf-auth-licenses-modal");
    if (!$modal.length) {
      $modal = $(".immobilgolf-auth-licenses-modal").first();
    }
    if (!$modal.length) {
      return;
    }

    // Escape Elementor/header stacking contexts so modal stays above sticky header.
    if ($modal.parent()[0] !== document.body) {
      $modal.appendTo(document.body);
    }

    licensesUrl =
      licensesUrl ||
      ($wrap && $wrap.data("portal-licenses-url")) ||
      (window.immobilgolfAuth && immobilgolfAuth.portalLicensesUrl) ||
      "https://portal.immobilgolf.com/index.php/api/registration_licenses/it";

    var $iframe = $modal.find(".immobilgolf-auth-licenses-modal__iframe");
    $iframe.attr("src", licensesUrl);

    if ($modal.data("closeTimer")) {
      clearTimeout($modal.data("closeTimer"));
      $modal.removeData("closeTimer");
    }

    $modal.removeAttr("hidden");
    $("body").addClass("immobilgolf-auth-licenses-open");

    // Next frame so CSS transition runs from closed → open.
    window.requestAnimationFrame(function () {
      window.requestAnimationFrame(function () {
        $modal.addClass("is-open");
      });
    });
  }

  function closeLicensesModal() {
    var $modal = $(".immobilgolf-auth-licenses-modal");
    if (!$modal.length || (!$modal.hasClass("is-open") && $modal.attr("hidden") !== undefined)) {
      return;
    }

    $modal.removeClass("is-open");
    $("body").removeClass("immobilgolf-auth-licenses-open");

    var reduceMotion =
      window.matchMedia &&
      window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    var duration = reduceMotion ? 0 : 320;

    if ($modal.data("closeTimer")) {
      clearTimeout($modal.data("closeTimer"));
    }

    var timer = setTimeout(function () {
      $modal.attr("hidden", true);
      $modal.find(".immobilgolf-auth-licenses-modal__iframe").attr("src", "about:blank");
      $modal.removeData("closeTimer");
    }, duration);
    $modal.data("closeTimer", timer);
  }

  $(document).on("click", "[data-close-licenses-modal]", function (e) {
    e.preventDefault();
    closeLicensesModal();
  });

  $(document).on("keydown", function (e) {
    if (e.key === "Escape") {
      closeLicensesModal();
    }
  });

  window.addEventListener("message", function (event) {
    if (!event.data || !event.data.type) {
      return;
    }

    // Only accept messages from Immobilgolf portal / site origins.
    var allowed = [
      "https://portal.immobilgolf.com",
      "https://immobilgolf.com",
      "https://www.immobilgolf.com",
    ];
    if (event.origin && allowed.indexOf(event.origin) === -1) {
      return;
    }

    if (event.data.type === "immobilgolf_registration_paid" && event.data.token) {
      closeLicensesModal();
      finishRegistrationReturn(event.data.token);
      return;
    }
    if (event.data.type === "immobilgolf_license_checkout" && event.data.checkoutUrl) {
      var checkoutUrl = String(event.data.checkoutUrl || "");
      if (checkoutUrl.indexOf("https://portal.immobilgolf.com/") !== 0) {
        return;
      }
      // Stripe stays in popup iframe; PayPal / free navigate the top window.
      if (event.data.method === "stripe") {
        var $iframe = $(".immobilgolf-auth-licenses-modal__iframe");
        if ($iframe.length) {
          $iframe.attr("src", checkoutUrl);
          return;
        }
      }
      window.top.location.href = checkoutUrl;
      return;
    }
  });

  function getQueryParam(name) {
    var params = new URLSearchParams(window.location.search);
    return params.get(name);
  }

  function clearRegQueryParams() {
    if (!window.history || !window.history.replaceState) {
      return;
    }
    var url = new URL(window.location.href);
    url.searchParams.delete("ig_reg");
    url.searchParams.delete("ig_reg_cancel");
    window.history.replaceState({}, document.title, url.pathname + url.search + url.hash);
  }

  function finishRegistrationReturn(token) {
    var statusUrl =
      (window.immobilgolfAuth && immobilgolfAuth.portalStatusUrl) ||
      "https://portal.immobilgolf.com/index.php/api/registration_status/it";
    var claimUrl =
      (window.immobilgolfAuth && immobilgolfAuth.portalClaimUrl) ||
      "https://portal.immobilgolf.com/index.php/api/registration_claim/it";
    var $wrap = $(".immobilgolf-auth-form").first();
    var $registerForm = $wrap.find('.immobilgolf-auth-form__form[data-form="register"]');
    var $msg = $registerForm.find(".immobilgolf-auth-form__message");
    if (!$msg.length) {
      $msg = $wrap.find(".immobilgolf-auth-form__message").first();
    }

    function clearRegisterForm() {
      if ($registerForm.length && $registerForm[0]) {
        $registerForm[0].reset();
      }
    }

    function showMsg(text, ok) {
      if (!$msg.length) {
        return;
      }
      $msg
        .removeAttr("hidden")
        .toggleClass("is-success", !!ok)
        .toggleClass("is-error", !ok)
        .text(text);
    }

    showMsg("Completamento registrazione…", true);

    var attempts = 0;
    var maxAttempts = 40;

    function poll() {
      attempts += 1;
      $.ajax({
        url: statusUrl,
        type: "GET",
        dataType: "json",
        data: { token: token },
        xhrFields: { withCredentials: true },
        crossDomain: true,
        cache: false,
      })
        .done(function (res) {
          if (res && res.success && res.paid) {
            clearRegisterForm();
            var isRenew =
              res.payload && res.payload.mode === "renew";
            $.ajax({
              url: claimUrl,
              type: "POST",
              dataType: "json",
              data: { token: token },
              xhrFields: { withCredentials: true },
              crossDomain: true,
            })
              .done(function (claim) {
                if (claim && claim.success) {
                  showMsg(
                    isRenew
                      ? "Licenza rinnovata con successo!"
                      : "Registrazione completata!",
                    true
                  );
                  clearRegQueryParams();
                  if ($wrap.length) {
                    checkPortalLogin($wrap);
                  }
                  return;
                }
                showMsg(
                  isRenew
                    ? "Pagamento ricevuto. Effettua di nuovo l'accesso."
                    : "Pagamento ricevuto. Accedi con la tua email e password.",
                  true
                );
                clearRegQueryParams();
              })
              .fail(function () {
                showMsg(
                  isRenew
                    ? "Pagamento ricevuto. Effettua di nuovo l'accesso."
                    : "Pagamento ricevuto. Accedi con la tua email e password.",
                  true
                );
                clearRegQueryParams();
              });
            return;
          }

          if (attempts < maxAttempts) {
            setTimeout(poll, 2000);
          } else {
            showMsg(
              "Il pagamento è in elaborazione. Accedi tra qualche minuto con la tua email e password.",
              false
            );
            clearRegQueryParams();
          }
        })
        .fail(function () {
          if (attempts < maxAttempts) {
            setTimeout(poll, 2000);
          } else {
            showMsg("Impossibile verificare il pagamento. Riprova più tardi.", false);
            clearRegQueryParams();
          }
        });
    }

    poll();
  }

  $(function () {
    var cancel = getQueryParam("ig_reg_cancel");
    if (cancel) {
      var $wrapCancel = $(".immobilgolf-auth-form").first();
      var $msgCancel = $wrapCancel.find(
        '.immobilgolf-auth-form__form[data-form="register"] .immobilgolf-auth-form__message'
      );
      if ($msgCancel.length) {
        $msgCancel
          .removeAttr("hidden")
          .removeClass("is-success")
          .addClass("is-error")
          .text("Pagamento annullato. Puoi riprovare la registrazione.");
        $wrapCancel.find('.immobilgolf-auth-form__tab[data-tab="register"]').trigger("click");
      }
      clearRegQueryParams();
      return;
    }

    var token = getQueryParam("ig_reg");
    if (token) {
      var $wrapReg = $(".immobilgolf-auth-form").first();
      if ($wrapReg.length) {
        $wrapReg.find('.immobilgolf-auth-form__tab[data-tab="register"]').trigger("click");
      }
      finishRegistrationReturn(token);
    }
  });
})(jQuery);
