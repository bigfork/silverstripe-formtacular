import Rule from './Rule';
import RuleSet from './RuleSet';

class NestedRuleSetRule extends Rule {
    constructor(parent, config) {
        super(parent, config);
        this.childRuleSet = new RuleSet(parent, config);
    }

    bind() {
        this.childRuleSet.bind();
    }

    getResult() {
        return this.childRuleSet.getResult();
    }

    refresh() {
        this.childRuleSet.refresh();
    }
}

export default NestedRuleSetRule;
