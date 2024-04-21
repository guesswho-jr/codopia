# Codopia V1.0

## Guys this will be the GitHub repo we are going to use

If you are reading it for the first time START HOSTING

I did everything you said but

- I didn't finish the dark mode but I started the code tho
- I didn't test the mailer because I was offline
- Fixed like a hundred bugs
- Tested it
- Tried to create JSON API but failed
- The test page sidebar looks weird!
- Dark mode did fail but I can share with you what I tried

    ```
if (localStorage.getItem('theme')==='dark') {
  const all = document.getElementsByTagName("*");
  document.querySelector("body").style.backgroundColor = "#121212"; // as Bonson said

  let newClassName="";
  for (let index = 0; index < all.length; index++) {
    for (let prop of all[index].classList){
      if (prop === "container"|| prop === "container-fluid"){
        all[index].classList.toggle("bg-dark")
      }
      if (prop.includes("light")){
        newClassName.concat(prop.replace(/light/, "dark"));
        all[index].classList.replace(prop, newClassName);
      }
      else if(prop.includes("dark")){
        newClassName.concat(prop.replace(/dark/, "light"));
        all[index].classList.replace(prop, newClassName);
      }
    }
    ```
It didn't work tho
## Hosting

- For the host I have heard that GoogieHost supports free mail server like [admin@codopia.blabla]("#") but I am not sure
- It also supports Node.js free. Hopefully.
- But InfintyFree is pretty solid.

Enjoy! We are git people now!!!

If you can't find me you can SMS me :) +251902645433

**IF YOU THINK IT IS SOLID FOR BETA PLEASE HOST IT**

WHAT ARE YOU WAITING FOR?
