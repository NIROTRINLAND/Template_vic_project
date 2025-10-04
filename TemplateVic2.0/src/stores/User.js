import { defineStore } from "pinia";

export const  useUserStore=defineStore('User',{
    state:()=>({
        User:''
    }),
    persist: true,
})
