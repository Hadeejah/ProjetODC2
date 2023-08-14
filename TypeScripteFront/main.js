"use strict";
let partie_Destinataire = document.querySelector(".partieDestinataire");
let selectTransaction = document.querySelector(".selectTransaction");
let selectFournisseur = document.querySelector(".selectFournisseur");
let titleTransac = document.querySelector(".titleTransac");
let btnValider = document.querySelector("#btnValider");
let expedi = document.querySelector("#expediteur");
let montant = document.querySelector("#montant");
let types_transac = document.querySelector("#type_transaction");
let destinataire = document.querySelector("#destinataire");
let inputNomEx = document.querySelector("#expediteur_nom");
let inputNomDe = document.querySelector("#destinataire_nom");
let forme = document.querySelector(".forme");
let btnAddUser = document.querySelector(".addUser");
let modal = document.querySelector(".modal");
let save = document.querySelector("#save");
let nom_client = document.querySelector("#nom_client");
let number = document.querySelector("#numero");
let modal1 = document.querySelector(".modal1");
let btnDet = document.querySelector("#btnDet");
let btnClose = document.querySelector(".btnClose");
let btnAddCompte = document.querySelector("#btnCompte");
let numero = document.querySelector(".num");
let solde = document.querySelector(".solde");
let fournisseur = document.querySelector(".selFourni");
let container = document.querySelector('.container');
let ajouter = document.querySelector("#ajouter");
let tbody = document.querySelector(".tbody");
let modalCompte = document.querySelector("#modalCompte");
let btnListCompte = document.querySelector("#btnListCompte ");
let modalListeCompte = document.querySelector("#modalListeCompte ");
console.log(modalListeCompte);
selectTransaction === null || selectTransaction === void 0 ? void 0 : selectTransaction.addEventListener("click", () => {
    if (selectTransaction.value == "retrait") {
        partie_Destinataire.style.display = "none";
    }
    else {
        partie_Destinataire.style.display = "block";
    }
});
selectFournisseur === null || selectFournisseur === void 0 ? void 0 : selectFournisseur.addEventListener("change", () => {
    switch (selectFournisseur.value) {
        case "wv":
            titleTransac.style.backgroundColor = "skyblue";
            break;
        case "wr":
            titleTransac.style.backgroundColor = "green";
            break;
        case "om":
            titleTransac.style.backgroundColor = "orange";
            break;
        case "cb":
            titleTransac.style.backgroundColor = "red";
            break;
        default:
            titleTransac.style.backgroundColor = "#80808000";
            break;
    }
});
expedi.addEventListener("input", () => {
    let expediteur = expedi.value;
    if (expediteur.length != 9) {
        return;
    }
    fetch("http://127.0.0.1:8000/api/getClient/" + expediteur, {
        headers: {
            "content-type": "application/json",
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((clients) => {
        inputNomEx.value = clients.nomComplet;
        expedi.id = clients.id;
        // console.log(clients);
    });
});
destinataire.addEventListener("input", () => {
    let desti = destinataire.value;
    if (desti.length != 9) {
        return;
    }
    fetch("http://127.0.0.1:8000/api/getClient/" + desti, {
        headers: {
            "content-type": "application/json",
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((clients) => {
        inputNomDe.value = clients.nomComplet;
        destinataire.id = clients.id;
    });
});
btnValider.addEventListener("click", () => {
    const Data = {
        idDestinataire: destinataire.id,
        idExpediteur: expedi.id,
        Type: types_transac.value,
        montant: montant.value,
    };
    console.log(Data);
    if (Data.Type == "depot") {
        fetch("http://127.0.0.1:8000/api/depot", {
            method: "POST",
            headers: {
                "content-type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(Data),
        })
            .then((response) => response.json())
            .then((data) => {
            data.message;
            notification(data.message);
        });
    }
    else if (Data.Type == "retrait") {
        fetch("http://127.0.0.1:8000/api/retrait", {
            method: "POST",
            headers: {
                "content-type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(Data),
        })
            .then((response) => response.json())
            .then((data) => {
            notification(data.message);
        });
    }
    else {
        fetch("http://127.0.0.1:8000/api/transfert", {
            method: "POST",
            headers: {
                "content-type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(Data),
        })
            .then((response) => response.json())
            .then((data) => {
            notification(data.message);
        });
    }
    forme.reset();
});
btnAddUser.addEventListener("click", () => {
    modal.style.display = "block";
    // console.log(modal);
});
save.addEventListener("click", () => {
    const Data1 = {
        nomComplet: nom_client.value,
        numero: number.value,
    };
    ;
    ;
    if (nom_client.value == "" || number.value == "") {
        notification('Veuillez remplir tout les champs');
    }
    else {
        fetch("http://127.0.0.1:8000/api/addUser", {
            method: "POST",
            headers: {
                "content-type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(Data1),
        })
            .then((response) => response.json())
            .then((data) => {
            data.message;
            notification(data.message);
        });
        modal.style.display = "none";
    }
});
btnDet.addEventListener("click", () => {
    modal1.style.display = "block";
    let tel = expedi.value;
    fetch("http://127.0.0.1:8000/api/getTransac/" + tel, {
        method: "GET",
        headers: {
            "content-type": "application/json",
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((donnees) => {
        const obj = donnees.data;
        const historique = obj.transac_ex;
        tbody.innerHTML = "";
        historique.forEach((element) => {
            let tr = document.createElement('tr');
            let td1 = document.createElement('td');
            let td2 = document.createElement('td');
            let td3 = document.createElement('td');
            let td4 = document.createElement('td');
            td1.innerText = element.Type;
            td2.innerText = element.idDestinateur.nomComplet;
            td3.innerText = element.DateHeure;
            td4.innerText = element.montant;
            tr.append(td1, td2, td3, td4);
            tbody.appendChild(tr);
        });
    });
});
btnClose.addEventListener("click", () => {
    modal1.style.display = "none";
});
function notification(text) {
    let notif = document.createElement("div");
    notif.textContent = text;
    notif.classList.add("notification");
    container.appendChild(notif);
    setTimeout(() => {
        container.removeChild(notif);
    }, 3000);
}
btnAddCompte.addEventListener("click", () => {
    modalCompte.style.display = "block";
});
ajouter.addEventListener("click", () => {
    const Data2 = {
        numero: numero.value,
        Solde: solde.value,
        fournisseur: fournisseur.value,
    };
    if (numero.value == "" || solde.value == "" || fournisseur.value == "") {
        notification('Veuillez remplir tout les champs');
    }
    else {
        fetch("http://127.0.0.1:8000/api/addCompte", {
            method: "POST",
            headers: {
                "content-type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(Data2),
        })
            .then((response) => response.json())
            .then((data) => {
            data.message;
            notification(data.message);
        });
        modalCompte.style.display = "none";
    }
});
btnListCompte.addEventListener('click', () => {
    modalListeCompte.style.display = "block";
    // alert('dfghjk')
});
