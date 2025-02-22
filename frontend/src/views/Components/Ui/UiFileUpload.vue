<template>
    <div class="mt-3">
        <label :class="{'text-red-600 dark:text-red-400':error}"
               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
               for="file_input">{{ $t('select_file') }}</label>
        <div class="flex flex-between w-full gap-2 justify-center">
            <button
                :class="{'cursor-not-allowed':disabled,'dark:border-red-500 dark:text-red-500 bg-red-500':error&&!modelValue,'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800':!error}"
                :disabled="disabled"
                class="w-1/2 mt-2 px-2 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 "
                type="button"
                @click="$refs.file_input.click()">
                {{ $t('load_file') }}
            </button>
            <button
                :class="{'cursor-not-allowed bg-gray-100':disabled||!modelValue,' text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800':modelValue,'border border-gray-200 hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-green-700 focus:text-green-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center':!modelValue}"
                :disabled="disabled||!modelValue"
                class="w-1/2 mt-2 p-2 text-sm font-medium text-center rounded-lg "
                type="button"
                @click="showFile"
            >
                {{ $t('open_file') }}
            </button>
        </div>

        <input ref="file_input" class="hidden" type="file" @change="handleChange">
    </div>

</template>

<script>
export default {
    name: "UiFileUpload",
    props: {
        disabled: {
            default: false
        },
        error: {
            default: false
        },
        modelValue: {
            default: null
        },

    },
    methods: {
        handleChange(e) {
            this.$emit('fileUpload', e.target.files[0]);
        },
        showFile() {
            window.open(window.location.origin + this.modelValue, '_blank');
        }
    },

};
</script>

<style scoped>

</style>
