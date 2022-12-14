jQuery(window).on("elementor:init", function () {
    var ElementorWPNForm = {
        renderField: function renderField(inputField, item) {
            var i = 1;

            inputField = '<input ' +
                'type="' + item.field_type + '" ' +
                'value="tel" ' +
                'class="elementor-field" ' +
                'name="form_field_' + i + '" id="form_field_' + i + '" ' + item.required + ' ' + item.placeholder + ' >';
            return inputField
        },
        init: function () {
            self = this;
            elementor.hooks.addFilter("elementor_pro/forms/content_template/field/wpn_field", this.renderField, 10, 2)
        }
    }
    ElementorWPNForm.init();
});
