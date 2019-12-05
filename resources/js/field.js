Nova.booting((Vue, router, store) => {
    Vue.component('index-quilljs', require('./components/IndexField'))
    Vue.component('detail-quilljs', require('./components/DetailField'))
    Vue.component('form-quilljs', require('./components/FormField'))
})
