const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    baseUrl: "http://localhost/themobilehour/", // Adjust if your port/path is different
    specPattern: "tests/frontend/**/*.cy.js",
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});