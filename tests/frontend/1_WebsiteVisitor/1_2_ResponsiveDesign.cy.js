describe('Responsive Design', () => {
  const url = '/index.php';

  context('Mobile viewport (iPhone 6)', () => {
    beforeEach(() => {
      cy.viewport('iphone-6');
      cy.visit(url);
    });

    it('shows the Latest Specials heading', () => {
      cy.contains('h1', 'Latest Specials!').should('be.visible');
    });

    it('shows filter and search forms', () => {
      cy.get('form').should('have.length.at.least', 2);
      cy.get('select[name="manufacturer_ID"]').should('be.visible');
      cy.get('input[placeholder="Min Price"]').should('be.visible');
      cy.get('input[placeholder="Max Price"]').should('be.visible');
      cy.get('input[type="search"]').should('be.visible');
    });

    it('shows at least one special product card', () => {
      cy.get('.item').should('have.length.at.least', 1);
    });

    it('shows Add to Cart and View Details buttons', () => {
      cy.get('.item-actions .btn').contains('Add to Cart').should('be.visible');
      cy.get('.item-actions .btn').contains('View Details').should('be.visible');
    });
  });

  context('Desktop viewport (1280x720)', () => {
    beforeEach(() => {
      cy.viewport(1280, 720);
      cy.visit(url);
    });

    it('shows the Latest Specials heading', () => {
      cy.contains('h1', 'Latest Specials!').should('be.visible');
    });

    it('shows filter and search forms', () => {
      cy.get('form').should('have.length.at.least', 2);
      cy.get('select[name="manufacturer_ID"]').should('be.visible');
      cy.get('input[placeholder="Min Price"]').should('be.visible');
      cy.get('input[placeholder="Max Price"]').should('be.visible');
      cy.get('input[type="search"]').should('be.visible');
    });

    it('shows at least one special product card', () => {
      cy.get('.item').should('have.length.at.least', 1);
    });

    it('shows Add to Cart and View Details buttons', () => {
      cy.get('.item-actions .btn').contains('Add to Cart').should('be.visible');
      cy.get('.item-actions .btn').contains('View Details').should('be.visible');
    });
  });
});