/*
 *
 * This class is taken from Matthew Eernisse book
 *
*/

// The var docForm should be a reference to a <form>

function formData2QueryString(docForm) {

    var submitContent = '';
    var formElem;
    var lastElemName = '';
    
    for (i = 0; i < docForm.elements.length; i++) {
        
        formElem = docForm.elements[i];
        switch (formElem.type) {
            // Text fields, hidden form elements
            case 'text':
            case 'hidden':
            case 'password':
            case 'textarea':
            case 'select-one':
                submitContent += formElem.name + '=' + escape(formElem.value) + '&'
                break;
                
            // Radio buttons
            case 'radio':
                if (formElem.checked) {
                    submitContent += formElem.name + '=' + escape(formElem.value) + '&'
                }
                break;
                
            // Checkboxes
            case 'checkbox':
                if (formElem.checked) {
                    // Continuing multiple, same-name checkboxes
                    if (formElem.name == lastElemName) {
                        // Strip of end ampersand if there is one
                        if (submitContent.lastIndexOf('&') == submitContent.length-1) {
                            submitContent = submitContent.substr(0, submitContent.length - 1);
                        }
                        // Append value as comma-delimited string
                        submitContent += ',' + escape(formElem.value);
                    }
                    else {
                        submitContent += formElem.name + '=' + escape(formElem.value);
                    }
                    submitContent += '&';
                    lastElemName = formElem.name;
                }
                break;
                
        }
    }
    // Remove trailing separator
    submitContent = submitContent.substr(0, submitContent.length - 1);
    return submitContent;
}