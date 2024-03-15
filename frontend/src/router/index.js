import { createRouter, createWebHistory } from "vue-router";
import User from "../modules/user/views";
import Tag from "../modules/tag/views";
import Post from "../modules/post/views";

const routes = [
  {
    path: "/usuarios",
    name: "User",
    component: User,
  },
  {
    path: "/tags",
    name: "Tag",
    component: Tag,
  },
  {
    path: "/posts",
    name: "Post",
    component: Post,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
