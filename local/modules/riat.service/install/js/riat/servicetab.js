class TabServiceCentr {

    constructor() {
        this.addButton()
    }

    addButton() {
        let tabMenu = document.querySelector('.crm-entity-section-tabs')
        let activeTabsArray = tabMenu.querySelector('.main-buttons-inner-container')
        let productTab = activeTabsArray.querySelector('div[data-id="tab_products"]')
        console.log(productTab)
        let scTabHtml = `
                <span class="main-buttons-item-link">
                    <span class="main-buttons-item-icon"></span>
                    <span class="main-buttons-item-text">
                        <span class="main-buttons-item-drag-button" data-slider-ignore-autobinding="true"></span>
                        <span class="main-buttons-item-text-title">
                            <span class="main-buttons-item-text-box">Просмотр записей сервисного центра
                                <span class="main-buttons-item-menu-arrow"></span>
                            </span>
                        </span>
                    <span class="main-buttons-item-edit-button" data-slider-ignore-autobinding="true"></span>
                    <span class="main-buttons-item-text-marker"></span>
                </span>
                <span class="main-buttons-item-counter"></span>
                </span>
        `
        if (productTab) {
            let div = document.createElement('div')
            div.id = 'crm_scope_detail_c_deal__tab_service_centr'
            div.className = "main-buttons-item"
            div.onclick = function () {
                window.open('/service_centr/')
            }
            div.innerHTML = scTabHtml
            let parent = productTab.parentNode
            parent.insertBefore(div, productTab)
        }
    }
}

BX.ready(function () {
    new TabServiceCentr()
});