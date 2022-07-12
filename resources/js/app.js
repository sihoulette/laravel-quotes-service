import './bootstrap';

const sharePost = {
    modalID: 'sharePost',
    formID: 'sharePostForm',

    /**
     * Open share modal form
     *
     * @param options {{}}
     */
    openModal: (options) => {
        const modalEl = $(document).find('#' + sharePost.modalID);
        if (modalEl.length > 0) {
            if (typeof options.url === 'string' && options.url.length > 0) {
                modalEl.find('form').attr('action', options.url);
                modalEl.find('input[name="post_id"]').val(options.id || '');
                if (typeof options.label === 'string') {
                    modalEl.find('label[for="data"]').text(options.label);
                }
                const shareModal = new bs.Modal(modalEl[0])
                $(modalEl).on('hidden.bs.modal', (e) => {
                    modalEl.find('input[name="data"]').val('');
                    modalEl.find('input[name="post_id"]').val('');
                });
                shareModal.show();
            } else {
                throw new Error('Attribute [data-url] must be set...');
            }
        } else {
            throw new Error('Modal element not found...');
        }
    },

    /**
     * Refresh share modal
     */
    refreshModal: () => {
        const modalEl = $(document).find('#' + sharePost.modalID);
        if (modalEl.length > 0) {
            modalEl.find('form').attr('action', '/');
            modalEl.find('input[name="data"]').val('');
            modalEl.find('input[name="post_id"]').val('');
            modalEl.find('.alert').addClass('d-none');
        } else {
            throw new Error('Modal element not found...');
        }
    },

    /**
     * Submit share modal form
     */
    submitForm: () => {
        const formEl = $(document).find('#' + sharePost.formID);
        if (typeof formEl === 'object' && formEl.length > 0) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: formEl.attr('action'),
                data: new FormData(formEl[0]),
                processData: false,
                contentType: false,
                cache: false,
                timeout: false,
                success: function (r) {

                },
                error: function (r) {
                    /** @var r.responseJSON {{}} */
                    if (r.status === 422) {
                        const inputEl = formEl.find('input[name="data"]'),
                            inputGroupEl = inputEl.closest('.input-group');
                        if (inputGroupEl.length > 0) {
                            const msgBoxEl = $(inputGroupEl).find('.invalid-feedback');
                            if (msgBoxEl.length > 0) {
                                let errorsHtml = '';
                                $.each(r.responseJSON.errors, (inputName, errors) => {
                                    $.each(errors, (index, msg) => {
                                        errorsHtml += '<div class="mb-1">' + msg + '</div>';
                                    });
                                });
                                msgBoxEl.html(errorsHtml);
                            }
                            inputEl.addClass('is-invalid')
                        }
                    }
                }
            });
        }
    },
};

$(document).ready(() => {
    // Open share modal form
    $(document).on('click', '[data-e="shareSocial"]', (e) => {
        e.preventDefault();
        const that = $(e.currentTarget);
        sharePost.openModal({
            id: that.data('id'),
            url: that.data('url'),
            label: that.data('name')
        });
    });

    // Submit share modal form
    $(document).on('submit', '#' + sharePost.formID, (e) => {
        e.preventDefault();
        sharePost.submitForm();
    });

    // Refresh share modal
    const shareModalEl = document.getElementById(sharePost.modalID);
    if (shareModalEl !== null) {
        shareModalEl.addEventListener('hidden.bs.modal', () => {
            sharePost.refreshModal();
        });
    }
});
