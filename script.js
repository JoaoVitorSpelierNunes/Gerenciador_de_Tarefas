const btnGenerate = document.querySelector("#generate-pdf");

btnGenerate.addEventListener("click", () => {

    const content = document.querySelector("#content");

    const options = {
        margin: [0, 0, 0, 0],
        filename: "ListaTarefas.pdf",
        html2canvas: {scale: 2},
        jsPDF: {unit: "mm", format: "a4", orientation: "portrait"}
    }

    html2pdf().set(options).from(content).save();

})