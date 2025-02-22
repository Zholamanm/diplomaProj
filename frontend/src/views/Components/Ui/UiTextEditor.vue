<template>
    <div class="mt-4" style="position: relative">
        <label v-if="label" :class="{'text-red-600 dark:text-red-400':error}"
               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="countries">{{ label }}</label>
        <element-tiptap :class="{disabled_class:disabled,'text-red-600':disabled}" :content="modelValue"
                        class="element_tiptap_render"
                        :extensions="extensions"
                        :readonly="disabled" @onUpdate="$emit('update:modelValue',$event)"
        />

    </div>
</template>

<script setup>
import {
    Blockquote,
    Bold,
    BulletList,
    Doc,
    ElementTiptap,
    Fullscreen,
    Heading,
    Image,
    Italic,
    OrderedList,
    Paragraph,
    Strike,
    Text,
    Underline,
    Link,
    Iframe
} from 'element-tiptap-vue3-fixed';

const CustomIframe = Iframe.extend({
    addAttributes() {
        return {
            ...this.parent?.(), // Keep existing attributes
            width: {
                default: '100%',
                renderHTML: attributes => {
                    return {
                        width: attributes.width || '100%',
                    }
                },
            },
            height: {
                default: '400',
                renderHTML: attributes => {
                    return {
                        height: attributes.height || '400',
                    }
                },
            },
        };
    }
});

const extensions = [
    Doc,
    Text,
    Paragraph,
    Blockquote,
    Heading,
    Bold,
    Underline,
    Italic,
    Strike,
    BulletList,
    OrderedList,
    Image,
    Fullscreen,
    Link,
    CustomIframe
];


defineProps({
    type: {
        default: 'text'
    },
    error: {
        default: false,

    },
    placeholder: {},
    disabled: {
        default: false
    },
    label: {},
    modelValue: {type: String, default: null},


});
defineEmits(['update:modelValue']);


</script>

<style>
.disabled_class .el-tiptap-editor__menu-bar, .disabled_class .el-tiptap-editor__content, .disabled_class .el-tiptap-editor__footer {
    background-color: lightgrey !important;
}

.element_tiptap_render{
    font:unset !important;
}
strong{
    font-weight:bold !important;
}
em{
    font-style: italic !important;
}
.element_tiptap_render iframe {
    width: 100% !important;
    height: 400px !important;
    max-width: 100% !important;
}

</style>
