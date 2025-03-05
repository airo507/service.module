BX.namespace('Riat.CompetenceEditActions');

BX.Riat.ServiceRecordAdd = {
    init: function (params) {
        this.params = params
        console.log(params)
        this.values = {}
        this.form = BX('serviceRecordAddForm');
        // this.setTagSelectors();
        this.bindEvents();
        console.log(this.params)

    },

    bindEvents: function() {
        let submitButton = BX('saveFormButton')
        let $this = this

        if (submitButton) {
            BX.bind(submitButton, 'click', function () {
                let data = new FormData($this.form)
                BX.ajax.runComponentAction('riat:service.record.add', 'addRecord', {
                    mode: 'class',
                    data: data,
                    dataType: 'json',
                }).then(function (response) {
                    console.log(response)
                }, function (response) {
                    console.log(response)
                });
                //BX.SidePanel.Instance.close();
            })
        }
        let cancelButton = BX('cancelFormButton')
        if (cancelButton) {
            BX.bind(cancelButton, 'click', function () {
                BX.SidePanel.Instance.close();
            })
        }
    },

    setTagSelectors: function () {
        const tagSelector = new BX.UI.EntitySelector.TagSelector({
            multiple: false,
            dialogOptions: {
                showAddButton: true,
                showTextBox: true,
                context: 'riat_leads',
                entities: [
                    {
                        id: 'lead',
                        dynamicLoad: true,
                        dynamicSearch: true,
                    },
                ],
            },
            events: {
                onAfterTagAdd: (event) => {
                    let tag = event.getData();
                    this.values.leadId = tag.tag.id;
                },
            }
        });
        if (this.params?.lead !== 0) {
            tagSelector.addTag(this.params?.lead)
        }
        tagSelector.renderTo(BX('leadSelector'));

        const postSelector = new BX.UI.EntitySelector.TagSelector({
            multiple: false,
            dialogOptions: {
                showAddButton: true,
                showTextBox: true,
                context: 'riat_posts',
                entities: [
                    {
                        id: 'iblock-element',
                        dynamicLoad: true,
                        dynamicSearch: true,
                        options: {
                            iblockId: this.params.postIblockId,
                        },
                    },
                ],
            },
            events: {
                onAfterTagAdd: (event) => {
                    let tag = event.getData();
                    this.values.postId = tag.tag.id;
                }
            }
        });
        if (this.params?.post !== 0) {
            postSelector.addTag(this.params.post)
        }
        postSelector.renderTo(BX('postSelector'));
    },
}