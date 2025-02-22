<template>
    <div class="mt-3">
        <label v-if="label" :class="{'text-red-600 dark:text-red-400':error}"
               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="countries">{{ label }}</label>
        <select id="countries"
                :class="{'dark:text-red-400 dark:border-red-400 dark:placeholder-red-500':error,'cursor-not-allowed bg-gray-50':disabled}"
                :disabled="disabled" :value="modelValue"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 focus:ring-green-500 focus:border-green-500"
                @change="handleChange">
            <option :disabled="defaultDisabled" selected value="">{{
                    selectedVal ? selectedVal : $t('choose')
                }}
            </option>
            <option v-for="option in options" :key="'option_'+option[optionLabel]" :value="option[optionValue]">
                {{ option[optionLabel] }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: "UiSelect",
    props: {
        options: {
            default: []
        },
        label: {},
        disabled: {
            default: false
        },
        modelValue: {},
        error: {
            default: false
        },
        optionValue: {
            default: 'id'
        },
        optionLabel: {
            default: 'value'
        },
        selectedVal: {
            default: null
        },
        defaultDisabled: {
            default: true
        }
    },
    data() {
        return {};
    },
    methods: {
        handleChange(e) {
            this.$emit('update:modelValue', e.target.value);
            this.$emit('changed');
        }
    },


};
</script>

<style scoped>

</style>
