<template>
    <div>
        <button aria-controls="sidebar"
                class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                data-drawer-target="sidebar" data-drawer-toggle="sidebar"
                type="button">
            <span class="sr-only">Open sidebar</span>
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                      d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                      fill-rule="evenodd"></path>
            </svg>
        </button>

        <aside id="sidebar"
               aria-label="Sidebar"
               class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
            <div class="h-screen px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                <div v-if="userData" class="flex items-center gap-4 mb-2">
                    <!--                                        <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="">-->
                    <svg class="w-10 h-10 text-gray-400 -left-1 rounded-full" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                              fill-rule="evenodd"></path>
                    </svg>
                    <div class="font-medium w-full dark:text-white">
                        <div>{{ userData.name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ userData.role.name }}</div>
                    </div>

                    <svg class="h-10 w-10 text-gray-500 cursor-pointer" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round"
                         stroke-width="2" viewBox="0 0 24 24" width="24" @click="logout()">
                        <path d="M0 0h24v24H0z" stroke="none"/>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                        <path d="M7 12h14l-3 -3m0 6l3 -3"/>
                    </svg>
                </div>

                <ul v-if="$store.state.user.user.districts&&$store.state.user.user.role_id==4"
                    class="space-y-0.5 py-1 text-xs text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
                    <li v-for="item in $store.state.user.user.districts">{{ item.name }}</li>
                </ul>

                <div class="flex flex-col justify-end" style="min-height: 90vh">
                    <ul class="space-y-2 font-medium border-t border-gray-200 dark:border-gray-700 ">
                        <li v-for="route in routes.filter((i)=>i.access)" :key="route.name" class="mt-3 "
                            style="height: auto">
                            <router-link
                                :class="{'dark:bg-green-600 dark:text-green-300 bg-green-100 text-green-800':route.child.includes($route.name)}"
                                :to="{name:route.name,params:{locale: $route.params.locale}}"
                                class="flex flex-row items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-green-200 dark:hover:bg-green-700 group"
                                style="cursor:pointer;height: auto">
                                <span class="" v-html="route.svg"></span>
                                <span class="ms-3">{{ route.label }}</span>
                            </router-link>
                        </li>
                    </ul>

                    <div class="p-2 mt-auto w-full bottom">
                        <label class="relative inline-flex cursor-pointer">
                            <input v-model="locale" class="sr-only peer" type="checkbox"
                                   @change="changeLang()">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-600 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-400"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{
                                    locale ? $t('ru') : $t('kk')
                                }}</span>
                        </label>
                    </div>

                </div>
            </div>
        </aside>
    </div>
</template>

<script>

import authApi from "../../api/AuthApi";
import i18nService from "../../services/i18n.service";
import commonData from "../../api/commonData";
import store from "../../store";
import dayjs from "dayjs";
import {initDrawers, initFlowbite} from 'flowbite';

export default {
    name: "Sidebar",
    data() {
        return {
            locale: this.$route.params.locale == 'ru',
            sidebarToggle: true,
            routes: [
                {
                    name: 'dashboardMain',
                    label: this.$t('dashboard'),
                    child: ['dashboardMain'],
                    access: [1, 2].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path d="M13.5 2a7 7 0 0 0-.5 0 1 1 0 0 0-1 1v8c0 .6.4 1 1 1h8c.5 0 1-.4 1-1v-.5A8.5 8.5 0 0 0 13.5 2Z"/>
    <path d="M11 6a1 1 0 0 0-1-1 8.5 8.5 0 1 0 9 9 1 1 0 0 0-1-1h-7V6Z"/>
  </svg>
  `

                },
                {
                    name: 'coursesList',
                    label: this.$t('courses'),
                    child: ['coursesList', 'courseCreate', 'courseItem', 'lessonCreate', 'lessonItem'],
                    access: [1].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M5 8h0m0 4h0m0 4h0"/>
  </svg>`

                },
                {
                    name: 'applicationsList',
                    label: this.$t('applications'),
                    child: ['applicationsList', 'applicationsItemCreate', 'applicationsItem'],
                    access: [1, 2, 4].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path fill-rule="evenodd" d="M8 3c0-.6.4-1 1-1h6c.6 0 1 .4 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8c0-.6.4-1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
  </svg>
  `
                },
  //               {
  //                   name: 'applicationsQueueList',
  //                   label: this.$t('applications-queue'),
  //                   child: ['applicationsQueueList', 'applicationsQueueItem'],
  //                   access: [1, 2, 4].includes(this.$store.state.user.user.role_id),
  //                   svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
  //   <path fill-rule="evenodd" d="M8 3c0-.6.4-1 1-1h6c.6 0 1 .4 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8c0-.6.4-1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
  // </svg>
  // `
  //               },
  //               {
  //                   name: 'agroApplicationsList',
  //                   label: this.$t('agrosauat'),
  //                   child: ['agroApplicationsList'],
  //                   access: [1, 2, 6].includes(this.$store.state.user.user.role_id), //set new role
  //                   svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
  //   <path fill-rule="evenodd" d="M8 3c0-.6.4-1 1-1h6c.6 0 1 .4 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8c0-.6.4-1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
  // </svg>
  // `
  //               },
                {
                    name: 'consultationsList',
                    label: this.$t('consultations'),
                    child: ['consultationsList', 'consultationsItem'],
                    access: [1,5].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path d="M2.038 5.61A2.01 2.01 0 0 0 2 6v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6c0-.12-.01-.238-.03-.352l-.866.65-7.89 6.032a2 2 0 0 1-2.429 0L2.884 6.288l-.846-.677Z"/>
  <path d="M20.677 4.117A1.996 1.996 0 0 0 20 4H4c-.225 0-.44.037-.642.105l.758.607L12 10.742 19.9 4.7l.777-.583Z"/>
</svg>
`
                },
                {
                    name: 'reports',
                    label: this.$t('reports'),
                    child: ['reports'],
                    access: [1, 2, 4, 5].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12.6l3-8a1 1 0 0 1 1-.6h12V9a2 2 0 0 0-2-2h-4.5l-2-2.3A2 2 0 0 0 8 4H4Zm2.7 8h-.2l-3 8H18l3-8H6.7Z" clip-rule="evenodd"/>
  </svg>
  `
                },
                {
                    name: 'contactsList',
                    label: this.$t('contacts'),
                    child: ['contactsList', 'contactsItem', 'contactsItemCreate'],
                    access: [1].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path d="M8 4a2.6 2.6 0 0 0-2 .9 6.2 6.2 0 0 0-1.8 6 12 12 0 0 0 3.4 5.5 12 12 0 0 0 5.6 3.4 6.2 6.2 0 0 0 6.6-2.7 2.6 2.6 0 0 0-.7-3L18 12.9a2.7 2.7 0 0 0-3.8 0l-.6.6a.8.8 0 0 1-1.1 0l-1.9-1.8a.8.8 0 0 1 0-1.2l.6-.6a2.7 2.7 0 0 0 0-3.8L10 4.9A2.6 2.6 0 0 0 8 4Z"/>
  </svg>
  `
                },
                {
                    name: 'userList',
                    label: this.$t('users'),
                    child: ['userList', 'userItemCreate', 'userItem'],
                    access: [1, 2, 4].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                          d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                          clip-rule="evenodd"/>
                                </svg>`

                },
                {
                    name: 'userLogs',
                    label: this.$t('userLogs'),
                    child: ['userLogs'],
                    access: [1].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                          d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                          clip-rule="evenodd"/>
                                </svg>`

                },
                {
                    name: 'historyList',
                    label: this.$t('history'),
                    child: ['historyList', 'historyItemCreate', 'historyItem'],
                    access: [1].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z" clip-rule="evenodd"/>
                            </svg>`
                },
                {
                    name: 'newsList',
                    label: this.$t('news'),
                    child: ['newsList', 'newsCreate', 'newsItem'],
                    access: [1].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z" clip-rule="evenodd"/>
                            </svg>
                        `
                },
                {
                    name: 'methodsList',
                    label: this.$t('methods'),
                    child: ['methodsList', 'methodsCreate', 'methodsItem'],
                    access: [1].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z" clip-rule="evenodd"/>
                            </svg>
                        `
                },
//                 {
//                     name: 'flowsDistList',
//                     label: this.$t('flows'),
//                     child: ['flowsDistList', 'flowsDistItem'],
//                     access: [1].includes(this.$store.state.user.user.role_id),
//                     svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
//   <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
// </svg>
// `
//                 },
                {
                    name: 'StatisticsMain',
                    label: this.$t('dashboard'),
                    child: ['StatisticsMain'],
                    access: [5].includes(this.$store.state.user.user.role_id),
                    svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path d="M13.5 2a7 7 0 0 0-.5 0 1 1 0 0 0-1 1v8c0 .6.4 1 1 1h8c.5 0 1-.4 1-1v-.5A8.5 8.5 0 0 0 13.5 2Z"/>
    <path d="M11 6a1 1 0 0 0-1-1 8.5 8.5 0 1 0 9 9 1 1 0 0 0-1-1h-7V6Z"/>
  </svg>
  `
                },


            ],
            userName: null,
            theme: null,
            loading: false
        };
    },
    methods: {
        logout() {
            authApi.logout().then(() => {
                this.$router.push({name: 'login', params: {locale: this.$route.params.locale}});
            });
        },
        changeLang() {

            let locale = this.locale ? 'ru' : 'kk';

            i18nService.setCurrentLocale(locale).then(() => {
                dayjs.locale(locale);
                this.$router.replace({params: {locale: locale}});
                store.commit('deleteData');
                this.loadData();
            });
        },
        loadData() {
            commonData.getCommonData().then(res => {
                let tmp = res;
                tmp.flows.forEach(x => {
                    x.date_string = this.$dayjs(x.start_date).format('D MMMM') + ' - ' + this.$dayjs(x.end_date).format('D MMMM');
                });
                store.commit('setData', tmp);
                this.commonIsReady = true;
            });
        }
    },
    computed: {
        userData() {
            return this.$store.state.user.user;
        }
    },
    mounted() {
        initFlowbite();
        initDrawers();
    }
};
</script>

<style scoped>

</style>
