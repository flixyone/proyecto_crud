export function addObject(userId, products) {
    localStorage.setItem(`cart_${userId}`, JSON.stringify(products));
  }

  export function getProducts(userId) {
    return JSON.parse(localStorage.getItem(`cart_${userId}`)) || [];
  }

  export function deleteObject(userId) {
    localStorage.removeItem(`cart_${userId}`);
  }

  export function addTotal(userId) {
    const products = getProducts(userId);
    return products.reduce((total, product) => total + product.subtotal, 0);
  }
