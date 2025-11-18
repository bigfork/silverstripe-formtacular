<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

use Error;
use LogicException;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormField;

class RuleSet
{
    use Configurable;
    use Injectable;

    protected string $operator = '';

    protected array $rules = [];

    protected ?Form $form = null;

    protected ?FormField $parentFormField = null;

    protected ?RuleSet $parentRuleSet = null;

    protected string $fluidSyntaxFieldName = '';

    public function __construct(string $operator = '', array $rules = [])
    {
        $this->setOperator($operator);
        $this->setRules($rules);
    }

    public function __call($name, $arguments)
    {
        $rules = $this->config()->get('fluid_syntax_rules') ?? [];
        if (isset($rules[$name])) {
            if (!$this->fluidSyntaxFieldName) {
                throw new Error('No field name set for fluid syntax');
            }

            array_unshift($arguments, $this->fluidSyntaxFieldName);
            $rule = Injector::inst()->createWithArgs($rules[$name], $arguments);
            $this->addRule($rule);
            return $this;
        }

        throw new Error("Call to undefined method " . __CLASS__ . "::{$name}()");
    }

    public function setForm(Form $form): RuleSet
    {
        $this->form = $form;

        /** @var AbstractRule $rule */
        foreach ($this->getRules() as $rule) {
            $rule->setForm($form);
        }

        return $this;
    }

    public function getResult(): bool
    {
        $result = $this->operator === 'or' ? false : true;

        /** @var AbstractRule $rule */
        foreach ($this->getRules() as $rule) {
            if (!$rule->canBeApplied()) {
                continue;
            }

            $result = $this->operator === 'or' ? ($result || $rule->getResult()) : ($result && $rule->getResult());
        }

        return $result;
    }

    public function setOperator(string $operator): RuleSet
    {
        if ($operator && !in_array($operator, ['or', 'and'])) {
            throw new LogicException('Operator must be one of "or" & "and"');
        }

        $this->operator = $operator;
        return $this;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function setRules(array $rules): RuleSet
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }

        return $this;
    }

    public function addRule(AbstractRule $rule): RuleSet
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function setFluidSyntaxFieldName(string $fieldName): RuleSet
    {
        $this->fluidSyntaxFieldName = $fieldName;
        return $this;
    }

    public function orIf(string $fieldName = ''): RuleSet
    {
        if ($this->operator === 'and') {
            throw new LogicException('Cannot use orIf() after using andIf() - use group() and nested rules instead');
        }

        $this->operator = 'or';
        return $this->setFluidSyntaxFieldName($fieldName);
    }

    public function andIf(string $fieldName = ''): RuleSet
    {
        if ($this->operator === 'or') {
            throw new LogicException('Cannot use andIf() after using orIf() - use group() and nested rules instead');
        }

        $this->operator = 'and';
        return $this->setFluidSyntaxFieldName($fieldName);
    }

    public function setParentFormField(FormField $field): RuleSet
    {
        $this->parentFormField = $field;
        return $this;
    }

    public function setParentRuleSet(RuleSet $ruleSet): RuleSet
    {
        $this->parentRuleSet = $ruleSet;
        return $this;
    }

    public function group(): RuleSet
    {
        $childRuleSet = RuleSet::create();
        $childRuleSet->setParentRuleSet($this);
        return $childRuleSet;
    }

    /**
     * @return RuleSet|FormField
     */
    public function end()
    {
        if (!$this->parentRuleSet) {
            if ($this->parentFormField) {
                return $this->parentFormField;
            }

            throw new LogicException('Cannot call end() on top-level rule set, did you forget to call group()?');
        }

        $rule = NestedRuleSetRule::create($this);
        return $this->parentRuleSet->addRule($rule);
    }

    public function getJavaScriptConfig(): array
    {
        $data = [
            'type' => $this->operator ?: 'or',
            'rules' => []
        ];

        /** @var AbstractRule $rule */
        foreach ($this->rules as $rule) {
            if (!$rule->canBeApplied()) {
                continue;
            }

            $data['rules'][] = $rule->getJavaScriptConfig();
        }

        return $data;
    }
}
