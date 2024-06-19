<div class="tbc-start" style="display: none;"></div>
<script>
    function chunkArray(array, n = 19) {
        if (!array) return;

        const result = array.reduce((resultArray, item, index) => {
            const chunkIndex = Math.floor(index / n)

            if (!resultArray[chunkIndex]) {
                resultArray[chunkIndex] = [] // start a new chunk
            }

            resultArray[chunkIndex].push(item)

            return resultArray
        }, [])

        return result;
    }

    const pdfHeader = `<?php require 'template-parts/pdf-parts/header.php'; ?>`


    let uniqueSections = {}

    document.addEventListener('DOMContentLoaded', function(e) {
        const tbcStart = document.querySelector('.tbc-start');
        let sections = [...document.querySelectorAll('section')];

        sections.splice(0, 2)
        sections.splice(-1)

        sections = sections.filter(section => section.querySelector('.section__title'))
        sections = sections.filter(section => section.querySelector('.section__footer'))

        sections.forEach(section => {
            const title = section.querySelector('.section__title span').textContent

            if (!uniqueSections[`${title}`]) {
                uniqueSections[`${title}`] = section
            }
        })

        sections = []
        for (const key in uniqueSections) {
            sections.push(uniqueSections[key])
        }

        sections = chunkArray(sections)
        sections.forEach(sections_chunk => {
            let sectionTbc = `<section class="section tbc">
                                <div class="section__container _container">
                                    ${pdfHeader}
                                    <div class="section__body">
                                        <div class="section__title">
                                            <span>Содержание</span>
                                            <img src="assets/img/icons/section-linear.svg" alt="">
                                        </div>
                                        <nav><ul>
                                    `

            sections_chunk.forEach(section => {
                const footer = section.querySelector('.section__footer')
                const titleElem = section.querySelector('.section__title')

                const page = footer.querySelector('.page').dataset.page
                title = titleElem.querySelector('span').textContent

                sectionTbc += `<li> 
                                <a href="#${section.id}">
                                    <span>${title}</span>
                                    <span>${page}</span>
                                </a>
                            </li>`
            })

            sectionTbc += `
                        </ul>
                        </nav>
                    </div>
                   <?php require 'template-parts/pdf-parts/footer.php'; ?>
                </div>
            </section>`

            tbcStart.insertAdjacentHTML('beforebegin', sectionTbc)
        })
    })
</script>