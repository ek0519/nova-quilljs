import IndexField from './components/IndexField';
import DetailField from './components/DetailField';
import FormField from './components/FormField';

Nova.booting((app, store) => {
    app.component('index-quilljs', IndexField)
    app.component('detail-quilljs', DetailField)
    app.component('form-quilljs', FormField)
})
