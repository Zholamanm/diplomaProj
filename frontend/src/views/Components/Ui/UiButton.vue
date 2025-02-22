<template>
    <button :class="computedClasses" :disabled="isLoading || disabled" @click="handleClick">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "UiButton",
    props: {
        type: {
            type: String,
            default: "success"
        },
        label: {
            type: String,
            default: ""
        },
        disabled: {
            type: Boolean,
            default: false
        },
        isLoading: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        computedClasses() {
            return [
                "btn",
                `btn-${this.type}`,
                {
                    "btn-disabled": this.disabled || this.isLoading
                }
            ];
        }
    },
    methods: {
        handleClick() {
            if (!this.disabled && !this.isLoading) {
                this.$emit("click");
            }
        }
    }
};
</script>

<style scoped>
.btn {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: .5rem 1rem;
    font-size: 1rem;
    border-radius: .375rem;
    transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-success {
    background-color: #34D399;
    color: #ffffff;
}

.btn-info {
    background-color: #3B82F6;
    color: #ffffff;
}

.btn-danger {
    background-color: #EF4444;
    color: #ffffff;
}

.btn:hover {
    filter: brightness(90%);
}

.btn-disabled {
    cursor: not-allowed;
    opacity: 0.6;
}
</style>
