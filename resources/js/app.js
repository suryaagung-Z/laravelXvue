import "./bootstrap";

import { createApp } from "vue";
import app from "./app.vue";
import router from "./route.js";

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faArrowLeft,
    faPenToSquare,
    faTrashCan,
    faTrashCanArrowUp,
} from "@fortawesome/free-solid-svg-icons";

library.add(faTrashCan, faTrashCanArrowUp, faPenToSquare, faArrowLeft);

const start = createApp(app);
start.use(router);
start.component("font-awesome-icon", FontAwesomeIcon);
start.mount("#app");
