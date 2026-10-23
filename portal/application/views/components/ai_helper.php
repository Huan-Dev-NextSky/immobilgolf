<div class="widget-content-ai-helper">
    <div class="padd">
        <button type="button" id="toggle-ai-form" class="btn btn-primary">
            <i class="icon-magic"></i> <?php echo lang_check('Populate form with AI') ?>
        </button>

        <div id="ai-form-container" style="display: none; margin-top: 15px;">
            <div class="form-group">
                <label class="control-label"><?php echo lang_check('Paste here existing content from another website/document') ?></label>
                <textarea id="ai-description" class="form-control" rows="4" placeholder="<?php echo lang_check('Enter property description, features, or any text you want to use to populate the form fields...') ?>"></textarea>
            </div>
            <div class="form-group">
                <button type="button" id="populate-with-ai" class="btn btn-success">
                    <i class="icon-wand"></i> <?php echo lang_check('Populate with AI') ?>
                </button>
                <button type="button" id="clear-ai-form" class="btn btn-default">
                    <i class="icon-remove"></i> <?php echo lang_check('Clear') ?>
                </button>
            </div>
            <div id="ai-loading" style="display: none;">
                <div class="alert alert-info">
                    <i class="icon-spinner icon-spin"></i> <?php echo lang_check('Processing with AI...') ?>
                </div>
            </div>
            <div id="ai-result" style="display: none;"></div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle AI form
        document.getElementById('toggle-ai-form').addEventListener('click', function() {
            const aiContainer = document.getElementById('ai-form-container');
            const icon = this.querySelector('i');

            if (aiContainer.style.display === 'none') {
                aiContainer.style.display = 'block';
                icon.classList.remove('icon-magic');
                icon.classList.add('icon-chevron-down');
            } else {
                aiContainer.style.display = 'none';
                icon.classList.remove('icon-chevron-down');
                icon.classList.add('icon-magic');
            }
        });

        // Populate with AI
        document.getElementById('populate-with-ai').addEventListener('click', function() {
            const description = document.getElementById('ai-description').value.trim();
            if (!description) {
                alert('<?php echo lang_check("Please enter a description first") ?>');
                return;
            }

            const button = this;
            const responseDiv = document.getElementById('ai-result');
            const loadingDiv = document.getElementById('ai-loading');

            // Disable button and show loading state
            button.disabled = true;
            button.innerHTML = '<i class="icon-spinner icon-spin"></i> <?php echo lang_check("Processing with AI...") ?>';
            loadingDiv.style.display = 'block';
            responseDiv.style.display = 'none';

            // Get all form data
            const formsJson = getAllFormsData();
            const encodedInput = encodeURIComponent(description);

            // Send data via fetch
            fetch('<?php echo site_url("aihelper/generateformdata"); ?>?form_num=form_1&ai_input=' + encodedInput, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: formsJson
                })
                .then(response => response.json())
                .then(data => {
                    loadingDiv.style.display = 'none';

                    if (data.status === 'success' && data.data) {
                        // Update the response message
                        responseDiv.innerHTML = '<div class="alert alert-success"><i class="icon-ok"></i> ' + (data.message || '<?php echo lang_check("Form populated successfully!") ?>') + '</div>';
                        responseDiv.style.display = 'block';

                        // Populate form fields
                        const formData = data.data;
                        const form = document.querySelector('form');

                        Object.entries(formData).forEach(([fieldName, fieldData]) => {
                            console.log(fieldName, fieldData.value);
                            // Find all inputs with the same name
                            const inputs = document.querySelectorAll(`[name="${fieldName}"]`);
                            console.log(inputs);

                            inputs.forEach(input => {
                                if (input.type === 'file') {
                                    // Skip file inputs
                                    return;
                                }

                                if (input.type === 'select-one') {
                                    // Handle select inputs
                                    const option = Array.from(input.options).find(opt =>
                                        opt.text === fieldData.value || opt.value === fieldData.value
                                    );
                                    if (option) {
                                        input.value = option.value;
                                    }
                                } else if (input.type === 'checkbox' || input.type === 'radio') {
                                    // Handle checkboxes and radio buttons
                                    if (input.type === 'checkbox') {
                                        // For checkboxes, check if the value is true, 'true', '1', or the checkbox's value
                                        const shouldBeChecked = fieldData.value === true ||
                                            fieldData.value === 'true' ||
                                            fieldData.value === '1' ||
                                            fieldData.value === input.value;
                                        input.checked = shouldBeChecked;
                                    } else {
                                        // For radio buttons, check if value matches
                                        if (input.value === fieldData.value) {
                                            input.checked = true;
                                        }
                                    }
                                } else if (input.tagName === 'TEXTAREA') {
                                    // Handle textarea inputs (including CKEditor)
                                    if (input.classList.contains('ckeditor') || input.id && CKEDITOR && CKEDITOR.instances[input.id]) {
                                        // This is a CKEditor textarea
                                        if (CKEDITOR && CKEDITOR.instances[input.id]) {
                                            CKEDITOR.instances[input.id].setData(fieldData.value);
                                        } else {
                                            // Fallback: set the textarea value directly
                                            input.value = fieldData.value;
                                        }
                                    } else {
                                        // Regular textarea
                                        input.value = fieldData.value;
                                    }
                                } else {
                                    // Handle text, date, number, etc.
                                    input.value = fieldData.value;
                                }

                                // Trigger change event to update any dependent fields
                                input.dispatchEvent(new Event('change', {
                                    bubbles: true
                                }));
                            });
                        });
                    } else if (data.status === 'error' && data.message) {
                        responseDiv.innerHTML = '<div class="alert alert-danger"><i class="icon-remove"></i> ' + data.message + '</div>';
                        responseDiv.style.display = 'block';
                    } else {
                        responseDiv.innerHTML = '<div class="alert alert-danger"><i class="icon-remove"></i> <?php echo lang_check("Error: Invalid response format") ?></div>';
                        responseDiv.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingDiv.style.display = 'none';
                    responseDiv.innerHTML = '<div class="alert alert-danger"><i class="icon-remove"></i> <?php echo lang_check("Network error occurred") ?></div>';
                    responseDiv.style.display = 'block';
                })
                .finally(() => {
                    // Reset button state
                    button.disabled = false;
                    button.innerHTML = '<i class="icon-wand"></i> <?php echo lang_check("Populate with AI") ?>';
                });
        });

        // Clear AI form
        document.getElementById('clear-ai-form').addEventListener('click', function() {
            document.getElementById('ai-description').value = '';
            document.getElementById('ai-result').style.display = 'none';
        });

        // Function to get all form data
        function getAllFormsData() {
            const forms = document.querySelectorAll('form');
            const formsData = {};

            // Build language mapping from language tabs
            const languageMapping = {};
            const languageTabs = document.querySelectorAll('.nav.nav-tabs.language_tabs li.lang a');
            languageTabs.forEach(tab => {
                const href = tab.getAttribute('href');
                const languageId = href.replace('#', '');
                const languageName = tab.textContent.trim();
                languageMapping[languageId] = languageName;
            });

            // Default language (usually English)
            const defaultLanguage = languageTabs.length > 0 ? languageTabs[0].getAttribute('href').replace('#', '') : '1';
            const defaultLanguageName = languageMapping[defaultLanguage] || 'English';

            forms.forEach((form, formIndex) => {
                const formData = {};
                const inputs = form.querySelectorAll('input, select, textarea');

                inputs.forEach(input => {
                    let label = '';
                    let language = defaultLanguageName;
                    let languageId = defaultLanguage;

                    // Find which language tab-pane contains this input
                    const tabPane = input.closest('.tab-pane');
                    if (tabPane && tabPane.id) {
                        languageId = tabPane.id;
                        language = languageMapping[languageId] || defaultLanguageName;
                    }

                    // Method 1: Look for label with 'for' attribute
                    if (input.id) {
                        const labelFor = document.querySelector(`label[for="${input.id}"]`);
                        if (labelFor) {
                            label = labelFor.textContent.trim();
                        }
                    }

                    // Method 2: Look for label in the same form-group or adjacent
                    if (!label) {
                        const formGroup = input.closest('.form-group');
                        if (formGroup) {
                            const labelInGroup = formGroup.querySelector('label');
                            if (labelInGroup) {
                                label = labelInGroup.textContent.trim();
                            }
                        }
                    }

                    // Method 3: Look for label in parent elements
                    if (!label) {
                        let parent = input.parentElement;
                        while (parent && parent !== form) {
                            const labelInParent = parent.querySelector('label');
                            if (labelInParent) {
                                label = labelInParent.textContent.trim();
                                break;
                            }
                            parent = parent.parentElement;
                        }
                    }

                    // Method 4: Look for label that comes before the input
                    if (!label) {
                        let previousElement = input.previousElementSibling;
                        while (previousElement) {
                            if (previousElement.tagName === 'LABEL') {
                                label = previousElement.textContent.trim();
                                break;
                            }
                            previousElement = previousElement.previousElementSibling;
                        }
                    }

                    // Method 5: Look for label in the same row/column structure
                    if (!label) {
                        const row = input.closest('.row, .col-lg-9, .col-lg-6, .col-lg-3');
                        if (row) {
                            const labelInRow = row.parentElement.querySelector('label');
                            if (labelInRow) {
                                label = labelInRow.textContent.trim();
                            }
                        }
                    }

                    // Method 6: Look for label by common patterns in this form
                    if (!label) {
                        // Try to find label by looking at the input's position relative to other labels
                        const allLabels = form.querySelectorAll('label');
                        const inputRect = input.getBoundingClientRect();

                        let closestLabel = null;
                        let closestDistance = Infinity;

                        allLabels.forEach(lbl => {
                            const labelRect = lbl.getBoundingClientRect();
                            const distance = Math.abs(inputRect.top - labelRect.top);

                            if (distance < closestDistance && distance < 50) { // Within 50px vertically
                                closestDistance = distance;
                                closestLabel = lbl;
                            }
                        });

                        if (closestLabel) {
                            label = closestLabel.textContent.trim();
                        }
                    }

                    formData[input.name] = {
                        value: input.type === 'checkbox' ? (input.checked ? input.value : '') : input.value,
                        type: input.type,
                        label: label,
                        placeholder: input.placeholder || '',
                        id: input.id || '',
                        language: language,
                        language_id: languageId,
                        ...(input.type === 'select-one' ? {
                            options: Array.from(input.options).map(opt => opt.value)
                        } : {})
                    };
                });

                formsData[`form_${formIndex + 1}`] = formData;
            });

            return JSON.stringify(formsData, null, 2);
        }

        // Get and log the JSON for debugging
        const formsJson = getAllFormsData();
        console.log('All Forms Data JSON:', formsJson);

        // Example of how to parse it back if needed
        const parsedData = JSON.parse(formsJson);
        console.log('Parsed Data:', parsedData);
    });
</script>