<template>
    <div class="mt-3">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
               :class="{'text-red-600 dark:text-red-400':error}">{{
                label
            }}</label>
        <ul class="grid w-full gap-6 md:grid-cols-2">
            <li v-for="(opt,index) in options" :class="{'cursor-not-allowed':disabled}">
                <input :ref="'radio_'+inputId+index" type="radio" :name="'radio_'+inputId"
                       :value="opt.value"
                       :disabled="disabled"
                       :checked="modelValue==opt.value"
                       class="hidden peer"
                       @change="handleChange">
                <label :for="'radio_' + inputId + index"
                       @click="disabled?'':clickInput('radio_'+inputId+index)"
                       :class="{'text-red-400 border-red-400 placeholder-red-500':error,'cursor-not-allowed bg-gray-100 hover:bg-gray-100 disabled_class':disabled,'bg-white hover:bg-green-100':!disabled}"
                       class="inline-flex items-center justify-between w-full p-2 text-gray-500 border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-green-500 peer-checked:border-green-300 peer-checked:text-green-600 hover:text-gray-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 peer-checked:bg-green-100">
                    <div class="block" :class="{'':disabled}">
                        <div class="w-full text-sm">{{ opt.label }}</div>
                    </div>
                </label>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "UiRadio",
    props: {
        inputId: {default: 0},
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
        }
    },
    data() {
        return {};
    },
    methods: {
        clickInput(input) {
            this.$refs[input][0].click();
        },
        handleChange(e) {
            this.$emit('update:modelValue', e.target.value);
        }
    }
};
</script>

<style scoped>
.disabled_class {
    background-color: grey;
}

</style>
