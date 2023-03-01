import RuleSet from './RuleSet';

/**
 * An object representing a field that has conditional visibility rules applied
 */
class FormtacularField {
    constructor(form, holderElement, ruleSetConfig, initiallyVisible) {
        this.form = form;
        this.holderElement = holderElement;
        this.ruleSetConfig = ruleSetConfig;
        this.initiallyVisible = initiallyVisible;

        this.ruleSet = new RuleSet(this, ruleSetConfig);
        this.ruleSet.bind();
    }

    getForm() {
        return this.form;
    }

    getHolderElement() {
        return this.holderElement;
    }

    getRuleSetConfig() {
        return this.ruleSetConfig;
    }

    getInitiallyVisible() {
        return this.initiallyVisible;
    }

    getRuleSet() {
        return this.ruleSet;
    }

    getIsVisible() {
        let visible = this.getRuleSet().getResult();

        // If the field was initially visible, this is "hideIf" rather than "displayIf", so reverse the result
        if (this.getInitiallyVisible()) {
            visible = !visible;
        }

        return visible;
    }

    onVisibilityChange() {
        if (this.getIsVisible()) {
            this.holderElement.classList.remove('formtacular-hidden');
        } else {
            this.holderElement.classList.add('formtacular-hidden');
        }
    }

    refresh() {
        this.getRuleSet().refresh();
    }
}

export default FormtacularField;
