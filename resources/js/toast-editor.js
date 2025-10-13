import '@toast-ui/editor/dist/toastui-editor.css';
import { Editor } from '@toast-ui/editor';

document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('#description-editor');
    if (!el) return;

    const initialValue = el.dataset.content || '';

    const editor = new Editor({
        el,
        height: '500px',
        initialEditType: 'markdown',
        previewStyle: 'vertical',
        initialValue,
        hooks: {
            async addImageBlobHook(blob, callback) {
                console.log('Image upload triggered');
                const url = await openLfm();
                if (url) {
                    callback(url, 'image');
                }
                return false;
            },
        },
    });

    const form = el.closest('form');
    if (form) {
        form.addEventListener('submit', () => {
            const textarea = form.querySelector('textarea[name="description"]');
            textarea.value = editor.getMarkdown();
        });
    }
});

function openLfm() {
    return new Promise((resolve) => {
        const routePrefix = '/laravel-filemanager';
        const x = Math.floor(window.innerWidth * 0.8);
        const y = Math.floor(window.innerHeight * 0.8);
        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

        const left = window.innerWidth / 2 - x / 2 + dualScreenLeft;
        const top = window.innerHeight / 2 - y / 2 + dualScreenTop;

        const popup = window.open(
            routePrefix + '?type=image',
            'FileManager',
            `width=${x},height=${y},top=${top},left=${left},scrollbars=yes`
        );

        window.SetUrl = (items) => {
            if (!items || !items.length) {
                resolve(null);
                return;
            }
            const filePath = items[0].url;
            resolve(filePath);
            popup.close();
        };
    });
}
