import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "Home",
            component: () => import("./components/Home.vue"),
        },
        {
            path: "/about",
            name: "About",
            component: () => import("./components/About.vue"),
        },
        {
            path: "/products",
            component: () =>
                import(
                    "./components/products/nested-product-page/Products.vue"
                ),
            children: [
                {
                    path: "",
                    name: "Products",
                    component: () =>
                        import(
                            "./components/products/nested-product-page/ProductsAll.vue"
                        ),
                },
                {
                    path: "trash",
                    name: "Products Trash",
                    component: () =>
                        import(
                            "./components/products/nested-product-page/ProductsTrash.vue"
                        ),
                },
            ],
            alias: "/products",
        },
        {
            path: "/products/add",
            name: "Add Product",
            component: () => import("./components/products/ProductsAdd.vue"),
        },
        {
            path: "/products/update/:id",
            name: "Update Product",
            component: () => import("./components/products/ProductsUpdate.vue"),
        },
        {
            path: "/contact",
            name: "Contact",
            component: () => import("./components/Contact.vue"),
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: () => import("./components/NotFound.vue"),
        },
    ],
});

router.beforeEach((to, from, next) => {
    document.title = to.name;
    next();
});

export default router;
