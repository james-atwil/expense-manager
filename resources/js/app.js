window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.bbxca = {
    settings: null,
    user: null,
    current: null
}


import {createApp} from 'vue'

import "bootstrap";
import {Tooltip} from "bootstrap";
import EventHandler from "bootstrap/js/src/dom/event-handler";

import NavArea from "./components/Sidebar/NavArea";
import NavSection from "./components/Sidebar/NavSection";
import NavItem from "./components/Sidebar/NavItem";
import ScrollArea from "./components/ScrollArea";
import Avatar from "./components/Navbar/Avatar";
import Notifications from "./components/Navbar/Notifications";


EventHandler.on(document, 'mouseover', '[data-bs-toggle="tooltip"]', function (event) {
    Tooltip.getOrCreateInstance(this, {boundary: document.body})
})

const BarsComponent = {
    components: {
        ScrollArea,
        NavArea,
        NavSection,
        NavItem,
        Avatar,
        Notifications
    }
}

const element = document.getElementById('bars');
if (typeof (element) != 'undefined' && element != null) {
    const bars = createApp(BarsComponent);
    bars.mount('#bars');
}

