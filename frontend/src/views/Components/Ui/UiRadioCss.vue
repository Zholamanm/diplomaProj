<template>
    <div class="ui-radio_css mt-3" :class="{ 'ui-radio--error_css': error, 'ui-radio--disabled_css': disabled }">
        <label class="ui-radio__label_css">{{ label }}</label>
        <ul class="ui-radio__list_css">
            <li v-for="(opt, index) in options" :key="index" class="ui-radio__item_css">
                <input
                    :id="'radio_' + inputId + index"
                    type="radio"
                    :name="'radio_' + inputId"
                    :value="opt.value"
                    :disabled="disabled"
                    :checked="modelValue === opt.value"
                    class="ui-radio__input_css"
                    @change="handleChange"
                />
                <label
                    :for="'radio_' + inputId + index"
                    class="ui-radio__option_css"
                    @click="clickInput('radio_' + inputId + index)"
                >
                    <div class="ui-radio__content_css">
                        <div class="ui-radio__text_css">{{ opt.label }}</div>
                    </div>
                </label>
            </li>
        </ul>
    </div>
</template>


<script>
export default {
    name: "UiRadioCss",
    props: {
        inputId: { default: 0 },
        options: { default: () => [] },
        label: { type: String, required: true },
        disabled: { type: Boolean, default: false },
        modelValue: { required: true },
        error: { type: Boolean, default: false },
        optionValue: {
            default: 'id'
        },
        optionLabel: {
            default: 'value'
        }
    },
    methods: {
        clickInput(input) {
            this.$refs[input][0].click();
        },
        handleChange(e) {
            this.$emit('update:modelValue', e.target.value);
        },
    },
}
</script>

<style scoped>
.ui-radio_css {
    --error-color: #dc2626;
    --disabled-bg: #f3f4f6;
    --default-border: #d1d5db;
    --hover-bg: #f0fdf4;
    --checked-bg: #d1fae5;
    --checked-border: #86efac;
    --text-color: #374151;
}

.ui-radio__label_css {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    font-size: 16px;
    color: #000;
}

.ui-radio--error_css .ui-radio__label_css {
    color: var(--error-color);
}

.ui-radio__list_css {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
}

.ui-radio__item_css {
    cursor: pointer;
}

.ui-radio__input_css {
    display: none;
}

.ui-radio__option_css {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--default-border);
    border-radius: 0.5rem;
    background-color: white;
    color: #000;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
}

.ui-radio__option_css:hover {
    background-color: var(--hover-bg);
}

.ui-radio__input_css:checked + .ui-radio__option_css {
    background-color: var(--checked-bg);
    border-color: var(--checked-border);
    color: var(--text-color);
}

.ui-radio--disabled_css .ui-radio__option_css {
    background-color: var(--disabled-bg);
    cursor: not-allowed;
}

.ui-radio--disabled_css .ui-radio__option_css:hover {
    background-color: var(--disabled-bg);
}

.ui-radio--error_css .ui-radio__option_css {
    border-color: var(--error-color);
    color: var(--error-color);
}

</style>
