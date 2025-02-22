<template>
    <div style="color:#5b5b5b; padding-bottom:5px; font-size:0.75em; line-height:15px;">
        Чтобы применить фильтры нажмите "применить фильтры". В случае закрытия окна фильтры не применятся.
    </div>
    <div class="flex justify-center items-end">
        <ui-select
            v-model="selectedFilter"
           :label="$t('choose')"
           :selected-val="'Выберите фильтр'"
           :option-label="'label'"
           :options="filteredInputsPick"
           :optionValue="'form_field'"
        />
        <ui-button
            @click="push"
            class="h-1/2 ml-2"
        >{{ $t('add') }}</ui-button>
    </div>
    <div style="display:flex; flex-direction:column;">
        <div v-for="input in filteredInputs" :key="input.form_field" style="position:relative;">
            <svg aria-hidden="true" class="w-3 h-3" fill="none" viewBox="0 0 14 14"
                 xmlns="http://www.w3.org/2000/svg"
                 style="position:absolute; top:15px; right:0; cursor:pointer; color:#9ca3af;" @click="hideFilter(input.form_field)">
                <path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" stroke="currentColor" stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"/>
            </svg>
            <ui-select v-if="input && input.input=='select'"
                       :key="input.form_field"
                       :value="input.value" @change="updateEvent($event.target.value, input)"
                       :disabled="loading||input.disabled"
                       :label="input.label"
                       :selected-val="selectedValueText.includes(input.form_field) ? selected(input.options, input.value)  : $t('select')"
                       :option-label="input.option_label"
                       :options="input.options?input.options:[]"
            />
            <ui-multi-select
                        v-else-if="input && input.input=='multi-select' && $store.state.user.user.role_id==1"
                        :key="input.form_field"
                        :value="input.value" @update:modelValue="updateEvent($event, input)"
                        :disabled="loading||input.disabled"
                        :label="input.label"
                        :option-label="input.option_label"
                        :options="input.options?input.options:[]"
            />
            <vue-date-picker
                        v-else-if="input && input.input=='date-picker'"
                        :key="input.form_field"
                        v-model="input.value" @update:modelValue="updateEvent($event, input)"
                        :cancel-text="$t('cancel')"
                        :enable-time-picker="false"
                        :format="dateFormat"
                        :locale="$route.params.locale=='ru'?'ru-RU':'kk-KK'"
                        :placeholder="$t('select_dates')"
                        :select-text="$t('select')"
                        month-name-format="long"
                        range style="width: unset; margin-top:35px;"
            />
            <ui-radio v-else-if="input && input.input=='radio'"
                      :key="input.form_field"
                      :v-model="input.value"
                      @update:modelValue="updateEvent($event, input)"
                      :disabled="loading||input.disabled"
                      :input-id="input.form_field"
                      :label="input.label"
                      :option-label="input.optionLabel"
                      :option-value="input.optionValue"
                      :options="input.options"
                      :model-value="input.value ?? null"
            />
        </div>
    </div>
    <div class="flex flex-col md:flex-row mt-5">
        <ui-button
            @click="dropFilters"
            class="h-1/2 ml-2 my-2"
            style="background-color: #ff4c4c;"
            :disabled="filteredInputs.length === 0"
        >Сбросить фильтры</ui-button>
        <ui-button
            @click="applyFilters"
            class="h-1/2 ml-2 my-2"
            :disabled="filteredInputs.length === 0"
        >Применить фильтры</ui-button>
    </div>
</template>

<script>
import UiInput from "./Ui/UiInput.vue";
import UiSelect from "./Ui/UiSelect.vue";
import UiMultiSelect from "./Ui/UiMultiSelect.vue";
import UiRadio from "./Ui/UiRadio.vue";
import UiButton from "./Ui/UiButton.vue";
import store from "../../store";
export default {
    name: "Filters",
    emits: ['callHideModal', 'text'],
    components: {UiMultiSelect, UiSelect, UiInput, UiRadio, UiButton, store},
    props: {
        inputs: {
            type: Object
        },
        loading:false,
        filters:{
            type: Object
        },
        selectedFilters: {
            type: [Array, String],
            default: () => []
        },
        text:Array
    },
    data(){
        return {
            selectedFilter:null,
            selectedFiltersInternal: Array.isArray(this.selectedFilters)
                ? this.selectedFilters
                : JSON.parse(this.selectedFilters) ?? [],
            selectedValueText: ['age_id', 'education_id', 'social_status_id', 'family_members_id', 'loans_amount_id', 'loans_month_payment_id', 'family_income_id', 'education_goal_id'],
            selectedValueLabel: ['gender_id', 'family_status', 'has_loans', 'loans_overdue', 'exists_iin', 'exists_district'],
            filtersInternal:{},
        }
    },
    methods: {
        updateEvent(value, input) {
            this.filtersInternal[input.form_field] = value;
            input.value = value;
            /*if(input.form_field == 'date_range'){
                console.log('value', value);
                input.value = this.$dayjs(value[0]).format('D MMMM YYYY')+ ' - ' +this.$dayjs(value[1]).format('D MMMM YYYY');
                console.log('input.value', input.value);
            }*/
        },
        push(){
            this.selectedFiltersInternal.push(this.selectedFilter);
            this.selectedFilter = null;
            this.$emit('update:selectedFilters', this.selectedFiltersInternal);
        },
        hideFilter(form_field){
            const index = this.selectedFilters.indexOf(form_field);
            if(index !== -1){
                this.selectedFilters.splice(index, 1);
            }
            const text_index = this.text.indexOf(form_field);
            if(text_index !== -1){
                this.text.splice(index, 1);
            }
        },
        applyFilters(){
            for (const key in this.filtersInternal) {
                if (this.filters.hasOwnProperty(key)) {
                    this.filters[key] = this.filtersInternal[key];
                }
            }

            this.text.length = 0; //очищаю proxy объект
            Object.entries(this.filters).forEach(([key, value]) => {
                if((this.selectedValueText.includes(key) || this.selectedValueLabel.includes(key) || key == 'date_range') && value !== null){
                    let elem = this.inputs.find(a => a.form_field == key);
                    if(this.selectedValueText.includes(elem.form_field)){
                        let option = elem.options.find(a => a.id == value);
                        this.text.push({
                            label: elem.label,
                            text: option.text
                        });
                    }else if(this.selectedValueLabel.includes(elem.form_field)){
                        let option = elem.options.find(a => a.value == value);
                        this.text.push({
                            label: elem.label,
                            text: option.label
                        });
                    }else if(elem.form_field == 'date_range'){
                        this.text.push({
                            label: elem.label,
                            text: this.$dayjs(value[0]).format('D MMMM YYYY')+ ' - ' +this.$dayjs(value[1]).format('D MMMM YYYY')
                        });
                    }
                }
            });

            this.$emit('text', this.text);
            this.$emit('callHideModal');
        },
        dropFilters(){
            this.filters['date_range'] = null;
            this.filters['age_id'] = null;
            this.filters['gender_id'] = null;
            this.filters['education_id'] = null;
            this.filters['social_status_id'] = null;
            this.filters['family_status'] = null;
            this.filters['family_members_id'] = null;
            this.filters['has_loans'] = null;
            this.filters['loans_amount_id'] = null;
            this.filters['loans_month_payment_id'] = null;
            this.filters['loans_overdue'] = null;
            this.filters['family_income_id'] = null;
            this.filters['education_goal_id'] = null;
            this.filters['exists_iin'] = null;
            this.filters['exists_district'] = null;

            this.filtersInternal = {};
            this.selectedFilters.length = 0;  // Очищаю так
            this.selectedFiltersInternal = [];
            this.text.length = 0;
            this.$emit('callHideModal');
        },
        selected(options, value){
            options = JSON.parse(JSON.stringify(options))
            let result = options.find(a => a.id == value);
            if(result){
                return result.text;
            }else{
                return this.$t('select');
            }
        }
    },
    computed:{
        filteredInputs() {
            return this.inputs.filter(a => this.selectedFilters.includes(a.form_field));
        },
        filteredInputsPick() {
            const s = new Set(this.selectedFiltersInternal);
            return this.inputs.filter(a => !s.has(a.form_field));
        }
    }

}
</script>

<style scoped>

</style>
