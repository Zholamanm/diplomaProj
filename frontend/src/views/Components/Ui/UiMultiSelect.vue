<template>
    <div class="mt-3" style="min-width: 150px">
        <label v-if="label" :class="{'text-red-600 dark:text-red-400':error}"
               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="countries">{{ label }}</label>
        <Multiselect
            :close-on-select="false"
            :disabled="disabled"
            :label="optionLabel"
            :model-value="modelValue"
            :options="options"
            :placeholder="placeholder"
            :value-prop="optionValue"
            mode="tags"
            @change="$emit('update:modelValue',$event)"
            @close="$emit('close')"
        />
    </div>

</template>

<script setup>
import Multiselect from "@vueform/multiselect";

defineProps({
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
    },
    multiple: {
        default: false
    },
    placeholder: {
        default: null
    }
});

defineEmits(['update:modelValue']);
</script>
<!--<style src="@vueform/multiselect/themes/default.css"></style>-->
<style scoped>
.multiselect .multiselect__content-wrapper {
    min-width: 100%;
    width: auto;
    border-top: 1px solid #e8e8e8;
}

.multiselect--active .multiselect__tags {
    border-bottom: none;
}
</style>
