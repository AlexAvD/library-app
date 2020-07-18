export const getNavItemsFromRoutes = (routes) => {
  const navRoutes = routes.filter((route) => {
    const { meta } = route;

    return meta && meta.nav && (typeof meta.nav.show === "undefined" || meta.nav.show);
  });

  const navConfig = navRoutes.map((route) => {
    return {
      name: route.name,
      label: route.meta.nav.label || "",
    };
  });

  return navConfig;
};
