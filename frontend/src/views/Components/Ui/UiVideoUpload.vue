<template>
    <div class="mt-3 ">
        <label :class="{'text-red-600 dark:text-red-400':error}"
               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">{{ label }}</label>
        <div class="p-3 w-full h-auto max-w-full border border-gray-200 rounded-lg dark:border-gray-700 flex flex-col"
             style="min-height: 400px"
             :class="{'border-red-500':error}"
        >
            <iframe :src="fileLink"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    class="w-full h-full rounded bg-gray-400"
                    frameborder="0" style="height: 100%;flex:1"></iframe>
            <input
                :value="modelValue"
                class="mt-3 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 focus:ring-green-500 focus:border-green-500"
                placeholder="X-XZx1o_w-A"
                @input="$emit('update:modelValue',$event.target.value)">

        </div>

    </div>
</template>

<script>
import UiInput from "./UiInput";

export default {
    components: {UiInput},
    props: {
        modelValue: {},
        label: {
            default: null
        },
        error: {
            default: false
        }
    },
    data() {
        return {};
    },
    methods: {
        changeUrlYT(url) {
            let match = url.match(/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/);
            return (match && match[7].length == 11) ? match[7] : url;
        }
    },
    computed: {

        fileLink() {
            return this.modelValue ? `https://www.youtube.com/embed/${this.changeUrlYT(this.modelValue)}?controls=0` : '';
        }
    }
};
</script>

<style scoped>

</style>
