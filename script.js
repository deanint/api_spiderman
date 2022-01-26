document.addEventListener("DOMContentLoaded", async() => {
    await load_data();
});

async function load_data() {
    const contentElement = document.getElementById("content");
    const request = await fetch("Api/list.php");
    const personnages = await request.json();
    contentElement.innerHTML = "";
    let i = 0
    for (const perso of personnages) {
        if (perso.amis === "TRUE") {
            perso.descriptions = "est un ami de Peter Parker "
        } else {
            perso.descriptions = "est un ennemi de Peter Parker "
        }

        contentElement.innerHTML += `
        <div class="center">
          <div class="property-card">
               <img src="${perso.imageSrc}" class="property-image" alt="">
            <div class="property-description">
              <h5> ${perso.acteur} </h5>
              <p>${perso.acteur} qui incarne le rôle de ${perso.name}</p>
               <p>${perso.name} ${perso.descriptions} </p>
            </div>
              <div class="property-social-icons">
               <button class="btn_edit" onclick="toggleModal(${i})">edit</button> 
                    <div class="modal item_${i}">
                         <div class="modal-content">
                            <button class="close-button"  onclick="toggleModal(${i})">x</button> 
                                <div>
                                    Name: <input type="text"  class="formulaire" id="name_input_edit_${i}" value="${perso.name}">
                                    acteur: <input type="text"  class="formulaire" id="acteur_input_edit_${i}" value="${perso.acteur}">
                                    Url-image: <input type="text"  class="formulaire" id="img_input_edit_${i}" value="${perso.imageSrc}">
                                    Amis :<select name="friend"  class="formulaire" id="friend-select_edit_${i}" >
                                                        <option value="TRUE">Oui</option>
                                                        <option value="FALSE">Non</option>
                                                </select>
                                  <button class="btn_edit"  onclick="edit_perso(${i})">edit</button> 
                                </div>
                        </div>
                    </div>
               <button class="btn_delete" onclick="delete_perso(${i})">supprimer</button> 
              </div>
          </div>
        </div>`;
        i++
    }
}

async function send_perso() {
    const name = document.getElementById("name_input").value;
    const friend = document.getElementById("friend-select").value;
    const urlPhoto = document.getElementById("img_input").value;
    const acteur = document.getElementById("acteur_input").value;
    const personnages = {
        "name": name,
        "acteur": acteur,
        "imageSrc": urlPhoto,
        "amis": friend
    };

    await fetch("Api/add.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(personnages)
    });
    await load_data();
}

async function delete_perso(key) {
    await fetch("Api/delete.php", {
        method: "DELETE",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(key)
    });

    await load_data();
}

async function edit_perso(key) {
    const name = document.getElementById(`name_input_edit_${key}`).value;
    const friend = document.getElementById(`friend-select_edit_${key}`).value;
    const urlPhoto = document.getElementById(`img_input_edit_${key}`).value;
    const acteur = document.getElementById(`acteur_input_edit_${key}`).value;
    const personnages = {
        "name": name,
        "acteur": acteur,
        "imageSrc": urlPhoto,
        "amis": friend,
        "key": key
    };
    // envoi du champion en POST
    await fetch("Api/edit.php", {
        method: "PUT",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(personnages, key)
    });
    await load_data();
}



function toggleModal(key) {
    const modal = document.querySelector(`.item_${key}`);
    modal.classList.toggle("show-modal");
}