import FormtacularField from './FormtacularField';

/**
 * An individual Rule represents a single test (e.g. ->isEqualTo('string')) that's checked against
 * a field. A single Rule may decide the visibility of a field, or it may be just one rule in a
 * RuleSet of many rules which collectively decide
 */
class Rule {
    constructor(parent, config) {
        this.parent = parent;
        this.config = config;
    }

    getParent() {
        return this.parent;
    }

    getConfig() {
        return this.config;
    }

    getForm() {
        if (typeof this.form === 'undefined') {
            this.form = null;
            let parent = this;
            while (parent = parent.getParent()) {
                if (parent instanceof FormtacularField) {
                    this.form = parent.getForm();
                    break;
                }
            }
        }

        return this.form;
    }

    onVisibilityChange() {
        this.getParent().onVisibilityChange();
    }

    getResult() {
        if (typeof this.result === 'undefined') {
            this.result = this.evaluate();
        }

        return this.result;
    }

    bind() {
        const inputs = window.formtacular_getFieldInputs(this.getForm(), this.getConfig());

        inputs.forEach((input) => {
            window.formtacular_bindChangeEvent(input, () => this.handleInputChange());
        });
    }

    handleInputChange() {
        this.refresh();
    }

    refresh() {
        let result = this.evaluate();
        if (result === this.result) {
            return;
        }

        this.result = result;
        this.onVisibilityChange();
    }

    evaluate() {
        const config = this.getConfig();
        const key = `formtacular_${config.test}`;
        return window[key](this.getForm(), config);
    }
}

export default Rule;
