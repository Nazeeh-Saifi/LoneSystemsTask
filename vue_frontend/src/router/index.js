import Vue from "vue";
import Router from "vue-router";

const AddSurvey = () => import("@/views/AddSurvey");
const Surveys = () => import("@/views/Surveys");
const TakeSurvey = () => import("@/views/TakeSurvey");
const Home = () => import("@/components/HelloWorld");
const Submissions = () => import("@/views/Submissions");

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
    path: "/surveys",
    component: {
      render(c) {
        return c("router-view");
      },
    },
    children: [
      {
        path: "",
        name: "Surveys",
        component: Surveys,
      },
      {
        path: ":id/take",
        name: "TakeSurvey",
        component: TakeSurvey,
      },
      {
        path: ":id/submissions",
        name: "Submissions",
        component: Submissions,
      },
    ],
  },
];

const router = new Router({
  routes,
});

Vue.use(Router);

export default router;
