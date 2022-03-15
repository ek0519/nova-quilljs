<template>
    <panel-item :field="field" >
        <template slot="value">
            <excerpt :content="converted" :should-show="field.shouldShow" />
        </template>
    </panel-item>
</template>

<script>
import QuillDeltaToHtmlConverter from "quill-delta-to-html";
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],

    data(){
        return {
            teste: null,
        }
    },

    computed: {
        converted() {
            var QuillDeltaToHtmlConverter = require('quill-delta-to-html').QuillDeltaToHtmlConverter
            
            if (this.field.isDelta) {
                var data = JSON.parse(this.field.value)
                var converter = new QuillDeltaToHtmlConverter(data, {});
                converter.renderCustomWith(customOp => {
                    
                    if (customOp.insert.type === 'mention') {
                        const { id, value, username } = customOp.insert.value;
                        return `<a
                          href="/resources/users/${id}"
                          target="_blank"
                          class="mention"
                          id="${id}"
                          >
                            @${value}
                          </a>`;
                                }
                                if (customOp.insert.type !== 'mention') return '';
                                return null;
                            });
                return converter.convert()
            } else {
                return this.field.value;
            }
        }


    }
}
</script>

<style>
.ql-video{
  width: 800px;
  height: 450px;
}

</style>
