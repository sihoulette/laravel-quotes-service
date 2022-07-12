import './bootstrap';
import jBox from "jbox";

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
                const shareModal = new bs.Modal(modalEl[0]);
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
            modalEl.find('input[name="post_id"]').val('');

            const dataInput = modalEl.find('input[name="data"]');
            dataInput.removeClass('is-invalid');
            dataInput.val('');
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
            const formData = new FormData(formEl[0]);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: formEl.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: false,
                success: function (r) {
                    if (r.success) {
                        const modalEl = formEl.closest('.modal');
                        if (modalEl.length > 0) {
                            $(modalEl).find('.btn-close').trigger('click');
                        }
                        /** @var r.share_count */
                        if (typeof r.share_count !== 'undefined') {
                            const shareBtnEl = $('#share-btn-' + formData.get('post_id'));
                            if (shareBtnEl.length > 0) {
                                shareBtnEl.find('.badge').text(r.share_count);
                            }
                        }
                    }
                    /** @var r.msg */
                    if (typeof r.msg === 'string' && r.msg.length > 0) {
                        new jBox('Notice', {
                            content: r.msg,
                            color: r.success ? 'green' : 'red',
                            autoClose: 1500
                        });
                    }
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
                        if (typeof r.responseJSON.message === 'string') {
                            new jBox('Notice', {
                                content: r.responseJSON.message,
                                color: 'red',
                                autoClose: 1500
                            });
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

    // Clean input error on change
    $(document).on('change', 'input[name="data"]', (e) => {
        const dataInput = $(e.currentTarget);
        if (dataInput.length > 0) {
            dataInput.removeClass('is-invalid');
        }
    });

    // Refresh share modal
    const shareModalEl = document.getElementById(sharePost.modalID);
    if (shareModalEl !== null) {
        shareModalEl.addEventListener('hidden.bs.modal', () => {
            sharePost.refreshModal();
        });
    }
});
