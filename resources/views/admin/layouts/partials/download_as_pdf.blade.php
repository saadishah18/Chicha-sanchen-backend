<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    const button = document.getElementById('download_as_pdf');

    function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('news_details_section');
        // Choose the element and save the PDF for your user.
        var opt = {
            margin:       1,
            filename:     '{{$news->slug}}'+'.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 1 },
            jsPDF:        { unit: 'em', format: 'legal', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save();
    }

    button.addEventListener('click', generatePDF);

</script>
