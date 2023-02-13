import FormtacularField from './FormtacularField';
import getFieldInputs from '../utils/getFieldInputs';

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
        const inputs = getFieldInputs(this.getForm(), this.getConfig());

        inputs.forEach((input) => {
            input.addEventListener('input', () => this.handleInputChange());
            input.addEventListener('change', () => this.handleInputChange());
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
        const test = window[config.test];
        return test(this.getForm(), config);
    }
}

export default Rule;
