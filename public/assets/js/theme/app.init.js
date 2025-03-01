var userSettings = {
  Layout: "vertical", // vertical | horizontal
  SidebarType: "full", // full | mini-sidebar
  BoxedLayout: true, // true | false
  Direction: "rtl", // ltr | rtl
  Theme: "light", // light | dark
  ColorTheme: "Blue_Theme", // Blue_Theme | Aqua_Theme | Purple_Theme | Green_Theme | Cyan_Theme | Orange_Theme
  cardBorder: false, // true | false
};
document.addEventListener("DOMContentLoaded", function () {
  applySettings();
});

function applySettings() {
  const settings = loadSettingsFromLocalStorage();

  if (settings.ColorTheme) {
      document.documentElement.setAttribute("data-color-theme", settings.ColorTheme);
  }

  if (settings.Theme) {
      document.documentElement.setAttribute("data-bs-theme", settings.Theme);
  }

  if (settings.Layout) {
      document.documentElement.setAttribute("data-layout", settings.Layout);
  }

  if (settings.Direction) {
      document.documentElement.setAttribute("dir", settings.Direction);
  }

  if (settings.SidebarType) {
      document.body.setAttribute("data-sidebartype", settings.SidebarType);
  }
}document.addEventListener("DOMContentLoaded", function () {
  applySettings();
});

function applySettings() {
  const settings = loadSettingsFromLocalStorage();

  if (settings.ColorTheme) {
      document.documentElement.setAttribute("data-color-theme", settings.ColorTheme);
  }

  if (settings.Theme) {
      document.documentElement.setAttribute("data-bs-theme", settings.Theme);
  }

  if (settings.Layout) {
      document.documentElement.setAttribute("data-layout", settings.Layout);
  }

  if (settings.Direction) {
      document.documentElement.setAttribute("dir", settings.Direction);
  }

  if (settings.SidebarType) {
      document.body.setAttribute("data-sidebartype", settings.SidebarType);
  }
}
