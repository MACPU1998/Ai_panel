document.addEventListener("DOMContentLoaded", function () {
    "use strict";
    var isSidebar = document.getElementsByClassName("side-mini-panel");
    if (isSidebar.length > 0) {
      var url = window.location + "";
      var path = url.replace(
        window.location.protocol + "//" + window.location.host + "/",
        ""
      );
  
      //****************************
      // Always create menus
      //****************************
      function createMenus() {
        document.querySelectorAll("#sidebarnav a").forEach(function (link) {
          link.addEventListener("click", function (e) {
            const isActive = this.classList.contains("active");
            const parentUl = this.closest("ul");
  
            if (!isActive) {
              // Hide all open menus and remove all other classes
              parentUl.querySelectorAll("ul").forEach(function (submenu) {
                submenu.classList.remove("in");
              });
              parentUl.querySelectorAll("a").forEach(function (navLink) {
                navLink.classList.remove("active");
              });
  
              // Open the new menu and add the active class
              const submenu = this.nextElementSibling;
              if (submenu) {
                submenu.classList.add("in");
              }
  
              this.classList.add("active");
            } else {
              this.classList.remove("active");
              parentUl.classList.remove("active");
              const submenu = this.nextElementSibling;
              if (submenu) {
                submenu.classList.remove("in");
              }
            }
          });
        });
  
        document
          .querySelectorAll("#sidebarnav > li > a.has-arrow")
          .forEach(function (link) {
            link.addEventListener("click", function (e) {
              e.preventDefault();
            });
          });
  
        // Ensure menus are visible even if no matching element is found
        document.querySelectorAll(".sidebarmenu nav").forEach(function (nav) {
          nav.classList.add("d-block");
        });
      }
  
      // Always create menus regardless of the current URL
      createMenus();
  
      //****************************
      // Find and activate matching elements
      //****************************
      function findMatchingElement() {
        var currentUrl = window.location.href;
        var anchors = document.querySelectorAll("#sidebarnav a");
  
        for (var i = 0; i < anchors.length; i++) {
          if (anchors[i].href === currentUrl) {
            return anchors[i];
          }
        }
  
        return null; // Return null if no matching element is found
      }
  
      var elements = findMatchingElement();
  
      if (elements) {
        elements.classList.add("active");
  
        // Highlight parent menus
        elements.closest("ul").classList.add("in");
        elements.closest("ul").parentElement.classList.add("selected");
      }
    }
  });
  