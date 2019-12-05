import Quill from 'quill'
import Link from 'quill/formats/link'

const ATTRIBUTES = [
    'height',
    'width'
  ];

  const BlockEmbed = Quill.import('blots/block/embed')

export class VideoBlot extends BlockEmbed {
    static create(url) {
      let node = super.create();
      // const vidWrapper = document.createElement('div');
      const regex = /facebook\.com\/[a-zA-Z0-9\.]+\/videos\/(?:[a-z0-9\.]+\/)?([0-9]+)\/?(.*)/gm
      if(regex.test(this.sanitize(url))){
        let facebook_prefix = 'https://www.facebook.com/plugins/video.php?href='
          node.setAttribute('src', facebook_prefix + encodeURIComponent(this.sanitize(url)))
      } else {
        node.setAttribute('src', this.sanitize(url));
      }
      node.setAttribute('frameborder', '0');
      node.setAttribute('allowfullscreen', true);
      // vidWrapper.className = "img video embed-responsive embed-responsive-16by9"
      // vidWrapper.appendChild(node);
      return node;
    }
    
    static formats(node) {
      let format = {};
      if (node.hasAttribute('height')) {
        format.height = node.getAttribute('height');
      }
      if (node.hasAttribute('width')) {
        format.width = node.getAttribute('width');
      }
      return format;
    }

    static sanitize(url) {
        return Link.sanitize(url);
      }
    
    static value(node) {
      return node.getAttribute('src');
    }
    
    format(name, value) {
      if (ATTRIBUTES.indexOf(name) > -1) {
        if (value) {
          this.domNode.setAttribute(name, value);
        } else {
          this.domNode.removeAttribute(name, value);
        }
      } else {
        super.format(name, value);
      }
    }
  }
  VideoBlot.blotName = 'video';
  VideoBlot.className = 'ql-video';
  VideoBlot.tagName = 'IFRAME';
