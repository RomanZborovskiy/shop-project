window.initToastEditor = function (selector = '.f-md-editor') {
    document.querySelectorAll(selector).forEach(function (wrapper) {
        const el = wrapper.querySelector('.toast-editor');
        const textarea = wrapper.querySelector('textarea');
        const initialValue = el.dataset.content || '';

        const editor = new toastui.Editor({
            el: el,
            height: '500px',
            initialEditType: 'markdown',
            previewStyle: 'vertical',
            initialValue: initialValue,
            hooks: {
                async addImageBlobHook(blob, callback) {
                    const url = await openLfm();
                    if (url) callback(url, 'image');
                    return false;
                },
            },
        });

        const form = el.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                textarea.value = editor.getMarkdown();
            });
        }
    });
};

function openLfm() {
    return new Promise((resolve) => {
        const routePrefix = '/laravel-filemanager';
        const x = Math.floor(window.innerWidth * 0.8);
        const y = Math.floor(window.innerHeight * 0.8);
        const left = window.innerWidth / 2 - x / 2;
        const top = window.innerHeight / 2 - y / 2;

        const popup = window.open(
            routePrefix + '?type=image',
            'FileManager',
            `width=${x},height=${y},top=${top},left=${left},scrollbars=yes`
        );

        window.SetUrl = (items) => {
            if (!items?.length) return resolve(null);
            resolve(items[0].url);
            popup.close();
        };
    });
}