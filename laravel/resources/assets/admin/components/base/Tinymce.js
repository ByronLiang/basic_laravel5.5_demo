/* eslint-disable */

//https://github.com/tinymce/tinymce
//https://www.tinymce.com/docs/

import load from 'common/helpers/load';
import FileUpload from '../../api/fileUpload';

export default {
    template: `<input type="hidden" :name="name" :value="value" />`,
    props: {
        name: String,
        config: Object,
        value: String
    },
    data() {
        return {
            is_focus: false,
            dcf: {
                autoresize_bottom_margin: 1,
                plugins: 'fullscreen preview print autoresize image media link table code help',
                images_upload_handler: this.imagesUploadHandler,
                init_instance_callback: this.initInstanceCallback
            }
        }
    },
    watch: {
        value(newVal, oldVal) {
            if (this.instance && !this.is_focus) {
                const content = this.instance.getContent();
                if (newVal && newVal !== content) {
                    this.instance.setContent(newVal);
                } else if (!newVal) {
                    this.instance.setContent('');
                }
            }
        },
    },
    methods: {
        initInstanceCallback(editor){
            editor.on('KeyUp', (e) => {
                this.$emit('input', editor.getContent());
            });
            editor.on('Change', (e) => {
                this.$emit('input', editor.getContent());
            });
            editor.on('focus', (e) => {
                this.is_focus = true;
            });
            editor.on('blur', (e) => {
                this.is_focus = false;
            });
            editor.setContent(this.value);
        },
        imagesUploadHandler(blobInfo, success, failure){
            // console.log(blobInfo.blob());
            // success('data:image/png;base64,' + blobInfo.base64());
            (new FileUpload())
                .imgOptions({
                    maxWidth: 1500
                })
                .uploadStart([blobInfo.blob()])
                .then(success)
                .catch(failure);
        },
        async init() {
            await load('tinymce');

            tinymce.addI18n('zh_CN', lang);

            let config = this.dcf;
            this.config && Object.assign(config, this.config);
            config.target = this.$el;
            let instance = await tinymce.init(config);
            this.instance = instance.length && instance[0];
        }
    },
    created() {
        this.init();
    },
    mounted() {
    },
    destroyed() {
        this.instance && this.instance.destroy();
    }
}

const lang = {
    "Cut": "\u526a\u5207",
    "Heading 5": "\u6807\u98985",
    "Header 2": "\u6807\u98982",
    "Your browser doesn't support direct access to the clipboard. Please use the Ctrl+X\/C\/V keyboard shortcuts instead.": "\u4f60\u7684\u6d4f\u89c8\u5668\u4e0d\u652f\u6301\u5bf9\u526a\u8d34\u677f\u7684\u8bbf\u95ee\uff0c\u8bf7\u4f7f\u7528Ctrl+X\/C\/V\u952e\u8fdb\u884c\u590d\u5236\u7c98\u8d34\u3002",
    "Heading 4": "\u6807\u98984",
    "Div": "Div\u533a\u5757",
    "Heading 2": "\u6807\u98982",
    "Paste": "\u7c98\u8d34",
    "Close": "\u5173\u95ed",
    "Font Family": "\u5b57\u4f53",
    "Pre": "\u9884\u683c\u5f0f\u6587\u672c",
    "Align right": "\u53f3\u5bf9\u9f50",
    "New document": "\u65b0\u6587\u6863",
    "Blockquote": "\u5f15\u7528",
    "Numbered list": "\u7f16\u53f7\u5217\u8868",
    "Heading 1": "\u6807\u98981",
    "Headings": "\u6807\u9898",
    "Increase indent": "\u589e\u52a0\u7f29\u8fdb",
    "Formats": "\u683c\u5f0f",
    "Headers": "\u6807\u9898",
    "Select all": "\u5168\u9009",
    "Header 3": "\u6807\u98983",
    "Blocks": "\u533a\u5757",
    "Undo": "\u64a4\u6d88",
    "Strikethrough": "\u5220\u9664\u7ebf",
    "Bullet list": "\u9879\u76ee\u7b26\u53f7",
    "Header 1": "\u6807\u98981",
    "Superscript": "\u4e0a\u6807",
    "Clear formatting": "\u6e05\u9664\u683c\u5f0f",
    "Font Sizes": "\u5b57\u53f7",
    "Subscript": "\u4e0b\u6807",
    "Header 6": "\u6807\u98986",
    "Redo": "\u91cd\u590d",
    "Paragraph": "\u6bb5\u843d",
    "Ok": "\u786e\u5b9a",
    "Bold": "\u7c97\u4f53",
    "Code": "\u4ee3\u7801",
    "Italic": "\u659c\u4f53",
    "Align center": "\u5c45\u4e2d",
    "Header 5": "\u6807\u98985",
    "Heading 6": "\u6807\u98986",
    "Heading 3": "\u6807\u98983",
    "Decrease indent": "\u51cf\u5c11\u7f29\u8fdb",
    "Header 4": "\u6807\u98984",
    "Paste is now in plain text mode. Contents will now be pasted as plain text until you toggle this option off.": "\u5f53\u524d\u4e3a\u7eaf\u6587\u672c\u7c98\u8d34\u6a21\u5f0f\uff0c\u518d\u6b21\u70b9\u51fb\u53ef\u4ee5\u56de\u5230\u666e\u901a\u7c98\u8d34\u6a21\u5f0f\u3002",
    "Underline": "\u4e0b\u5212\u7ebf",
    "Cancel": "\u53d6\u6d88",
    "Justify": "\u4e24\u7aef\u5bf9\u9f50",
    "Inline": "\u6587\u672c",
    "Copy": "\u590d\u5236",
    "Align left": "\u5de6\u5bf9\u9f50",
    "Visual aids": "\u7f51\u683c\u7ebf",
    "Lower Greek": "\u5c0f\u5199\u5e0c\u814a\u5b57\u6bcd",
    "Square": "\u65b9\u5757",
    "Default": "\u9ed8\u8ba4",
    "Lower Alpha": "\u5c0f\u5199\u82f1\u6587\u5b57\u6bcd",
    "Circle": "\u7a7a\u5fc3\u5706",
    "Disc": "\u5b9e\u5fc3\u5706",
    "Upper Alpha": "\u5927\u5199\u82f1\u6587\u5b57\u6bcd",
    "Upper Roman": "\u5927\u5199\u7f57\u9a6c\u5b57\u6bcd",
    "Lower Roman": "\u5c0f\u5199\u7f57\u9a6c\u5b57\u6bcd",
    "Id should start with a letter, followed only by letters, numbers, dashes, dots, colons or underscores.": "\u6807\u8bc6\u7b26\u5e94\u8be5\u4ee5\u5b57\u6bcd\u5f00\u5934\uff0c\u540e\u8ddf\u5b57\u6bcd\u3001\u6570\u5b57\u3001\u7834\u6298\u53f7\u3001\u70b9\u3001\u5192\u53f7\u6216\u4e0b\u5212\u7ebf\u3002",
    "Name": "\u540d\u79f0",
    "Anchor": "\u951a\u70b9",
    "Id": "\u6807\u8bc6\u7b26",
    "You have unsaved changes are you sure you want to navigate away?": "\u4f60\u8fd8\u6709\u6587\u6863\u5c1a\u672a\u4fdd\u5b58\uff0c\u786e\u5b9a\u8981\u79bb\u5f00\uff1f",
    "Restore last draft": "\u6062\u590d\u4e0a\u6b21\u7684\u8349\u7a3f",
    "Special character": "\u7279\u6b8a\u7b26\u53f7",
    "Source code": "\u6e90\u4ee3\u7801",
    "Language": "\u8bed\u8a00",
    "Insert\/Edit code sample": "\u63d2\u5165\/\u7f16\u8f91\u4ee3\u7801\u793a\u4f8b",
    "B": "B",
    "R": "R",
    "G": "G",
    "Color": "\u989c\u8272",
    "Right to left": "\u4ece\u53f3\u5230\u5de6",
    "Left to right": "\u4ece\u5de6\u5230\u53f3",
    "Emoticons": "\u8868\u60c5",
    "Robots": "\u673a\u5668\u4eba",
    "Document properties": "\u6587\u6863\u5c5e\u6027",
    "Title": "\u6807\u9898",
    "Keywords": "\u5173\u952e\u8bcd",
    "Encoding": "\u7f16\u7801",
    "Description": "\u63cf\u8ff0",
    "Author": "\u4f5c\u8005",
    "Fullscreen": "\u5168\u5c4f",
    "Horizontal line": "\u6c34\u5e73\u5206\u5272\u7ebf",
    "Horizontal space": "\u6c34\u5e73\u8fb9\u8ddd",
    "Insert\/edit image": "\u63d2\u5165\/\u7f16\u8f91\u56fe\u7247",
    "General": "\u666e\u901a",
    "Advanced": "\u9ad8\u7ea7",
    "Source": "\u5730\u5740",
    "Border": "\u8fb9\u6846",
    "Constrain proportions": "\u4fdd\u6301\u7eb5\u6a2a\u6bd4",
    "Vertical space": "\u5782\u76f4\u8fb9\u8ddd",
    "Image description": "\u56fe\u7247\u63cf\u8ff0",
    "Style": "\u6837\u5f0f",
    "Dimensions": "\u5927\u5c0f",
    "Insert image": "\u63d2\u5165\u56fe\u7247",
    "Image": "\u56fe\u7247",
    "Zoom in": "\u653e\u5927",
    "Contrast": "\u5bf9\u6bd4\u5ea6",
    "Back": "\u540e\u9000",
    "Gamma": "\u4f3d\u9a6c\u503c",
    "Flip horizontally": "\u6c34\u5e73\u7ffb\u8f6c",
    "Resize": "\u8c03\u6574\u5927\u5c0f",
    "Sharpen": "\u9510\u5316",
    "Zoom out": "\u7f29\u5c0f",
    "Image options": "\u56fe\u7247\u9009\u9879",
    "Apply": "\u5e94\u7528",
    "Brightness": "\u4eae\u5ea6",
    "Rotate clockwise": "\u987a\u65f6\u9488\u65cb\u8f6c",
    "Rotate counterclockwise": "\u9006\u65f6\u9488\u65cb\u8f6c",
    "Edit image": "\u7f16\u8f91\u56fe\u7247",
    "Color levels": "\u989c\u8272\u5c42\u6b21",
    "Crop": "\u88c1\u526a",
    "Orientation": "\u65b9\u5411",
    "Flip vertically": "\u5782\u76f4\u7ffb\u8f6c",
    "Invert": "\u53cd\u8f6c",
    "Date\/time": "Date\/time",
    "Insert date\/time": "\u63d2\u5165\u65e5\u671f\/\u65f6\u95f4",
    "Remove link": "\u5220\u9664\u94fe\u63a5",
    "Url": "\u5730\u5740",
    "Text to display": "\u663e\u793a\u6587\u5b57",
    "Anchors": "\u951a\u70b9",
    "Insert link": "\u63d2\u5165\u94fe\u63a5",
    "Link": "Link",
    "New window": "\u5728\u65b0\u7a97\u53e3\u6253\u5f00",
    "None": "\u65e0",
    "The URL you entered seems to be an external link. Do you want to add the required http:\/\/ prefix?": "\u4f60\u6240\u586b\u5199\u7684URL\u5730\u5740\u5c5e\u4e8e\u5916\u90e8\u94fe\u63a5\uff0c\u9700\u8981\u52a0\u4e0ahttp:\/\/:\u524d\u7f00\u5417\uff1f",
    "Paste or type a link": "Paste or type a link",
    "Target": "\u6253\u5f00\u65b9\u5f0f",
    "The URL you entered seems to be an email address. Do you want to add the required mailto: prefix?": "\u4f60\u6240\u586b\u5199\u7684URL\u5730\u5740\u4e3a\u90ae\u4ef6\u5730\u5740\uff0c\u9700\u8981\u52a0\u4e0amailto:\u524d\u7f00\u5417\uff1f",
    "Insert\/edit link": "\u63d2\u5165\/\u7f16\u8f91\u94fe\u63a5",
    "Insert\/edit video": "\u63d2\u5165\/\u7f16\u8f91\u89c6\u9891",
    "Media": "Media",
    "Alternative source": "\u955c\u50cf",
    "Paste your embed code below:": "\u5c06\u5185\u5d4c\u4ee3\u7801\u7c98\u8d34\u5728\u4e0b\u9762:",
    "Insert video": "\u63d2\u5165\u89c6\u9891",
    "Poster": "\u5c01\u9762",
    "Insert\/edit media": "Insert\/edit media",
    "Embed": "\u5185\u5d4c",
    "Nonbreaking space": "\u4e0d\u95f4\u65ad\u7a7a\u683c",
    "Page break": "\u5206\u9875\u7b26",
    "Paste as text": "\u7c98\u8d34\u4e3a\u6587\u672c",
    "Preview": "\u9884\u89c8",
    "Print": "\u6253\u5370",
    "Save": "\u4fdd\u5b58",
    "Could not find the specified string.": "\u672a\u627e\u5230\u641c\u7d22\u5185\u5bb9.",
    "Replace": "\u66ff\u6362",
    "Next": "\u4e0b\u4e00\u4e2a",
    "Whole words": "\u5168\u5b57\u5339\u914d",
    "Find and replace": "\u67e5\u627e\u548c\u66ff\u6362",
    "Replace with": "\u66ff\u6362\u4e3a",
    "Find": "\u67e5\u627e",
    "Replace all": "\u5168\u90e8\u66ff\u6362",
    "Match case": "\u533a\u5206\u5927\u5c0f\u5199",
    "Prev": "\u4e0a\u4e00\u4e2a",
    "Spellcheck": "\u62fc\u5199\u68c0\u67e5",
    "Finish": "\u5b8c\u6210",
    "Ignore all": "\u5168\u90e8\u5ffd\u7565",
    "Ignore": "\u5ffd\u7565",
    "Add to Dictionary": "\u6dfb\u52a0\u5230\u5b57\u5178",
    "Insert row before": "\u5728\u4e0a\u65b9\u63d2\u5165",
    "Rows": "\u884c",
    "Height": "\u9ad8",
    "Paste row after": "\u7c98\u8d34\u5230\u4e0b\u65b9",
    "Alignment": "\u5bf9\u9f50\u65b9\u5f0f",
    "Border color": "\u8fb9\u6846\u989c\u8272",
    "Column group": "\u5217\u7ec4",
    "Row": "\u884c",
    "Insert column before": "\u5728\u5de6\u4fa7\u63d2\u5165",
    "Split cell": "\u62c6\u5206\u5355\u5143\u683c",
    "Cell padding": "\u5355\u5143\u683c\u5185\u8fb9\u8ddd",
    "Cell spacing": "\u5355\u5143\u683c\u5916\u95f4\u8ddd",
    "Row type": "\u884c\u7c7b\u578b",
    "Insert table": "\u63d2\u5165\u8868\u683c",
    "Body": "\u8868\u4f53",
    "Caption": "\u6807\u9898",
    "Footer": "\u8868\u5c3e",
    "Delete row": "\u5220\u9664\u884c",
    "Paste row before": "\u7c98\u8d34\u5230\u4e0a\u65b9",
    "Scope": "\u8303\u56f4",
    "Delete table": "\u5220\u9664\u8868\u683c",
    "H Align": "\u6c34\u5e73\u5bf9\u9f50",
    "Top": "\u9876\u90e8\u5bf9\u9f50",
    "Header cell": "\u8868\u5934\u5355\u5143\u683c",
    "Column": "\u5217",
    "Row group": "\u884c\u7ec4",
    "Cell": "\u5355\u5143\u683c",
    "Middle": "\u5782\u76f4\u5c45\u4e2d",
    "Cell type": "\u5355\u5143\u683c\u7c7b\u578b",
    "Copy row": "\u590d\u5236\u884c",
    "Row properties": "\u884c\u5c5e\u6027",
    "Table properties": "\u8868\u683c\u5c5e\u6027",
    "Bottom": "\u5e95\u90e8\u5bf9\u9f50",
    "V Align": "\u5782\u76f4\u5bf9\u9f50",
    "Header": "\u8868\u5934",
    "Right": "\u53f3\u5bf9\u9f50",
    "Insert column after": "\u5728\u53f3\u4fa7\u63d2\u5165",
    "Cols": "\u5217",
    "Insert row after": "\u5728\u4e0b\u65b9\u63d2\u5165",
    "Width": "\u5bbd",
    "Cell properties": "\u5355\u5143\u683c\u5c5e\u6027",
    "Left": "\u5de6\u5bf9\u9f50",
    "Cut row": "\u526a\u5207\u884c",
    "Delete column": "\u5220\u9664\u5217",
    "Center": "\u5c45\u4e2d",
    "Merge cells": "\u5408\u5e76\u5355\u5143\u683c",
    "Insert template": "\u63d2\u5165\u6a21\u677f",
    "Templates": "\u6a21\u677f",
    "Background color": "\u80cc\u666f\u8272",
    "Custom...": "\u81ea\u5b9a\u4e49...",
    "Custom color": "\u81ea\u5b9a\u4e49\u989c\u8272",
    "No color": "\u65e0",
    "Text color": "\u6587\u5b57\u989c\u8272",
    "Table of Contents": "Table of Contents",
    "Show blocks": "\u663e\u793a\u533a\u5757\u8fb9\u6846",
    "Show invisible characters": "\u663e\u793a\u4e0d\u53ef\u89c1\u5b57\u7b26",
    "Words: {0}": "\u5b57\u6570\uff1a{0}",
    "Insert": "\u63d2\u5165",
    "File": "\u6587\u4ef6",
    "Edit": "\u7f16\u8f91",
    "Rich Text Area. Press ALT-F9 for menu. Press ALT-F10 for toolbar. Press ALT-0 for help": "\u5728\u7f16\u8f91\u533a\u6309ALT-F9\u6253\u5f00\u83dc\u5355\uff0c\u6309ALT-F10\u6253\u5f00\u5de5\u5177\u680f\uff0c\u6309ALT-0\u67e5\u770b\u5e2e\u52a9",
    "Tools": "\u5de5\u5177",
    "View": "\u89c6\u56fe",
    "Table": "\u8868\u683c",
    "Format": "\u683c\u5f0f",
    "Align": "对齐",
    "Preformatted": "预格式化",
};
