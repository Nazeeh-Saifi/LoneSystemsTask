import Vue from "vue";
import Router from "vue-router";

const AddSurvey = () => import("@/views/AddSurvey");
const TakeSurvey = () => import("@/views/TakeSurvey");
const Home = () => import("@/components/HelloWorld");

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/add-survey",
    component: {
      render(c) {
        return c("router-view");
      },
    },
    children: [
      {
        path: "",
        name: "AddSurvey",
        component: AddSurvey,
      },
    ],
  },
  {
    path: "/take-survey",
    component: {
      render(c) {
        return c("router-view");
      },
    },
    children: [
      {
        path: "",
        name: "TakeSurvey",
        component: TakeSurvey,
      },
    ],
  },
];

const router = new Router({
  routes,
});

Vue.use(Router);

export default router;
