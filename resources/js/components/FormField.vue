<template>
  <default-field :field="field" :errors="errors" :full-width-content="field.width">
    <template slot="field">
      <quill-editor
        :style="css"
        v-model="value"
        ref="myQuillEditor"
        :options="editorOption"
        @blur="onEditorBlur($event)"
        @focus="onEditorFocus($event)"
        @ready="onEditorReady($event)"
      ></quill-editor>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import { quillEditor, Quill } from "vue-quill-editor";
import BlotFormatter from "quill-blot-formatter";
import { ImageExtend, QuillWatch } from "quill-image-extend-module";
import { VideoBlot } from "../../quilljs/VideoBlot";
import Tooltip from "quill/ui/tooltip";
import { CustomImageSpec } from '../../quilljs/CustomImageSpec';
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";

Quill.register({
  "modules/ImageExtend": ImageExtend,
  "modules/blotFormatter": BlotFormatter,
  "ui/tooltip": Tooltip,
  "formats/video": VideoBlot
});


export default {
  mixins: [FormField, HandlesValidationErrors],
  components: {
    quillEditor
  },
  props: ["resourceName", "resourceId", "field"],
  data() {
    return {
      toolbarTips: this.field.tooltip,
      editorOption: {
        placeholder: this.field.placeholder,
        modules: {
          // ...
          blotFormatter: {
            specs: [CustomImageSpec],
          },
          ImageExtend: {
            loading: true,
            size: this.field.maxFileSize ? this.field.maxFileSize : 2,
            name: "attachment",
            action: `/nova-vendor/quilljs/${this.resourceName}/upload/${this.field.attribute}`,
            response: res => {
              return res.url;
            },
            headers: xhr => {
              xhr.setRequestHeader(
                "X-CSRF-TOKEN",
                document.head.querySelector('meta[name="csrf-token"]').content
              );
            },
            sizeError: () => {
              this.$toasted.show(`Image size exceeds ${(this.field.maxFileSize ? this.field.maxFileSize : 2)}MB`, { type: "error" });
            },
            change: (xhr, formData) => {
              formData.append("draftId", this._uuid());
            }
          },

          toolbar: {
            container: this.field.options,
            handlers: {
              image() {
                QuillWatch.emit(this.quill.id);
              },
              video(value) {
                this.quill.theme.tooltip.edit("video");
              }
            }
          }
        }
      }
    };
  },
  methods: {
    _uuid() {
      var d = Date.now();
      if (
        typeof performance !== "undefined" &&
        typeof performance.now === "function"
      ) {
        d += performance.now(); //use high-precision timer if available
      }
      return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(
        c
      ) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c === "x" ? r : (r & 0x3) | 0x8).toString(16);
      });
    },
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || "";
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || "");
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value;
    },

    onEditorBlur(quill) {
      // console.log("editor blur!", quill);
    },
    onEditorFocus(quill) {
      // console.log("editor focus!", quill);
    },
    onEditorReady(quill) {
      // console.log("editor ready!", quill);
    },
    onEditorChange({ quill, html, text }) {
      console.log("editor change!", quill, html, text);
      this.content = html;
    }
  },
  computed: {
    editor() {
      return this.$refs.myQuillEditor.quill;
    },
    css(){
        return {
            height: this.field.height + 'px',
            'padding-bottom': '10px'
        }
    }
  },
  mounted() {
    autotip: {
      if (this.toolbarTips) {
        for (let item of this.toolbarTips) {
          let tip = document.querySelector(".quill-editor " + item.Choice);
          if (!tip) continue;
          tip.setAttribute("title", item.title);
        }
      }
    }
  }
};
</script>

<style>
.ql-editor p {
  margin-top: 18px;
  font-size: 18px;
}
.ql-video {
  width: 800px;
  height: 450px;
}
</style>
