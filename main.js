//vamos a llamar a la API
console.log("hola")
function resolveAfter2Seconds() {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve('resolved');
      }, 2000);
    });
  }
async function callApi(){
    const api = fetch('https://openlibrary.org/works/OL15822113W.json', {mode:'cors' });
    const resultBook = await api;
    const jsonBook = await resultBook.json();
    console.log(jsonBook);
    console.log("calling");
    const result = await resolveAfter2Seconds();//espera mientras se resuelve la promesa
    console.log(result);


}

callApi();
console.log("Is calling")