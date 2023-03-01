import Rule from './Rule';
import RuleSet from './RuleSet';

/**
 * A NestedRuleSetRule is a special type of rule that defers its checks to a set of child rules.
 * This is used when ->group() is called to group multiple checks together
 */
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
