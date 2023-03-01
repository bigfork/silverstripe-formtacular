import NestedRuleSetRule from './NestedRuleSetRule';
import Rule from './Rule';

/**
 * A RuleSet contains a list of rules that either belong directly to a field, or are nested with
 * a NestedRuleSetRule. The result of the visibility check performed on a RuleSet is the sum of
 * the results of its child Rules.
 */
class RuleSet {
    constructor(parent, config) {
        this.parent = parent;
        this.config = config;

        this.rules = [];
        config.rules.forEach((rule) => {
            rule = rule.rules ? new NestedRuleSetRule(this, rule) : new Rule(this, rule);
            this.rules.push(rule);
        });
    }

    getParent() {
        return this.parent;
    }

    getConfig() {
        return this.config;
    }

    getType() {
        return this.config.type;
    }

    getRules() {
        return this.rules;
    }

    bind() {
        this.getRules().forEach((rule) => {
            rule.bind();
        });
    }

    onVisibilityChange() {
        this.getParent().onVisibilityChange();
    }

    getResult() {
        let result = this.getType() === 'or' ? false : true;
        this.getRules().forEach((rule) => {
            result = (this.getType() === 'or') ? (result || rule.getResult()) : (result && rule.getResult());
        });
        return result;
    }

    refresh() {
        this.getRules().forEach((rule) => {
            rule.refresh();
        });
    }
}

export default RuleSet;
