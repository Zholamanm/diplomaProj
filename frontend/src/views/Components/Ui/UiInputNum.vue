<template>
    <div class="relative flex items-center">

        <label for="counter-input" v-if="label" class="block mr-3 text-sm font-medium text-gray-900 dark:text-white"  :class="{'text-red-600 dark:text-red-400':error}">{{ label }}</label>

        <button type="button" @click="decrement" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
            </svg>
        </button>

        <input type="text"
               class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
               :class="{'text-red-800 border border-red-300 dark:text-red-400 dark:border-red-400 dark:placeholder-red-500':error,'cursor-not-allowed bg-gray-50':disabled}"
               :name="label"
               :placeholder="placeholder"
               :disabled="disabled"
               :value="counter"
               :max="maxLength"
               @input="updateValue($event.target.value)"
               required=""
               id="counter-input"/>

        <button type="button" @click="increment" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
        </button>
    </div>
</template>
<script>
export default {
    props: {
        error: {
            default: false,
        },
        placeholder: {},
        disabled: {
            default: false
        },
        label: {},
        modelValue: [String, Number],
        maxLength: {
            default: null
        }
    },
    data() {
        return {
            counter: this.modelValue
        };
    },
    watch: {
        modelValue(newValue) {
            this.counter = newValue;
        }
    },
    methods: {
        increment() {
            if(this.maxLength && this.counter < this.maxLength) {
                this.counter++;
                this.$emit('update:modelValue', this.counter);
                this.$emit('input', this.counter);
            }else if(!this.maxLength){
                this.counter++;
                this.$emit('update:modelValue', this.counter);
                this.$emit('input', this.counter);
            }
        },
        decrement() {
            if (this.counter > 0) {
                this.counter--;
                this.$emit('update:modelValue', this.counter);
                this.$emit('input', this.counter);
            }
        },
        updateValue(value) {
            const newValue = parseInt(value, 10);
            if (!isNaN(newValue)) {
                this.counter = newValue;
                this.$emit('update:modelValue', this.counter);
                this.$emit('input', this.counter);
            }
        }
    }
}
</script>
<style scoped>

</style>
