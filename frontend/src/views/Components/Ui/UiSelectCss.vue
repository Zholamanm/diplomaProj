<template>
    <div class="ui-select_css mt-3">
        <label v-if="label" class="ui-select__label_css" :class="{ 'ui-select__label--error_css': error }" for="countries">
            {{ label }}
        </label>
        <select
            id="countries"
            class="ui-select__control_css"
            :class="{ 'ui-select__control--error_css': error, 'ui-select__control--disabled_css': disabled }"
            :disabled="disabled"
            :value="modelValue"
            @change="handleChange"
        >
            <option :disabled="defaultDisabled" selected value="">{{ selectedVal || $t('choose') }}</option>
            <option
                v-for="option in options"
                :key="'option_' + option[optionLabel]"
                :value="option[optionValue]"
            >
                {{ option[optionLabel] }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: "UiSelectCss",
    props: {
        options: { type: Array, default: () => [] },
        label: { type: String, default: "" },
        disabled: { type: Boolean, default: false },
        modelValue: { required: true },
        error: { type: Boolean, default: false },
        optionValue: { type: String, default: "id" },
        optionLabel: { type: String, default: "value" },
        selectedVal: { type: String, default: null },
        defaultDisabled: { type: Boolean, default: true },
    },
    methods: {
        handleChange(e) {
            this.$emit("update:modelValue", e.target.value);
            this.$emit("changed");
        },
    },
}
</script>

<style scoped>
.ui-select_css {
    --error-color: #dc2626;
    --default-border-color: #d1d5db;
    --focus-color: #10b981;
    --text-color: #374151;
    --background-color: #f9fafb;
    --disabled-bg-color: #f3f4f6;
    --dark-bg: #1f2937;
    --dark-border: #4b5563;
    --dark-placeholder: #9ca3af;
    --dark-focus-ring: #10b981;
}

.ui-select__label_css {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    font-size: 16px;
    color: #000;
}

.ui-select__label--error_css {
    color: var(--error-color);
}

.ui-select__control_css {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 14px;
    color: var(--text-color);
    background-color: var(--background-color);
    border: 1px solid var(--default-border-color);
    border-radius: 8px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.ui-select__control_css:hover {
    border-color: var(--focus-color);
}

.ui-select__control_css:focus {
    border-color: var(--focus-color);
    box-shadow: 0 0 4px var(--focus-color);
    outline: none;
}

.ui-select__control--error_css {
    border-color: var(--error-color);
    color: var(--error-color);
}

.ui-select__control--disabled_css {
    background-color: var(--disabled-bg-color);
    cursor: not-allowed;
}

.ui-select__control--disabled_css:hover {
    border-color: var(--default-border-color);
}

.ui-select__control_css:disabled {
    background-color: var(--disabled-bg-color);
    cursor: not-allowed;
}

/* Dark theme */
.dark .ui-select__label_css {
    color: #f9fafb;
}

.dark .ui-select__control_css {
    color: var(--dark-placeholder);
    background-color: var(--dark-bg);
    border-color: var(--dark-border);
}

.dark .ui-select__control_css:focus {
    border-color: var(--dark-focus-ring);
    box-shadow: 0 0 4px var(--dark-focus-ring);
}

</style>
