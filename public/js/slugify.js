const slugify = str =>
    str
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');

const sanitizeTitle = str => str;

const putSlugInInputField = (titleId = '#name',slugId = '#slug') => {
    $(titleId).on('input',function (e){
        let value = $(this).val();
        let test = slugify(value)
        $(slugId).val(test);
        $(titleId).val(sanitizeTitle(value));
    });
}

//this function is specifically used for post section
//where we need to prepend string
const putSlugInInputFieldForPost = (titleId = '#name',slugId = '#slug',postTypeId) => {
    $(titleId).on('input',function (e){
        let value = $(this).val();
        let slug = slugify(value);
        console.log(slug);

        if (postTypeId == 5){
            if(slug && slug.length && !slug.includes('virgin-islands')){
                slug = 'virgin-islands-'+slug;
            }
        }else{
            if(slug && slug.length && !slug.includes('caribbean')) {
                slug = 'caribbean-' + slug;
            }
        }
        $(slugId).val(slug);
        $(titleId).val(sanitizeTitle(value));
    });
}
const putSlugInInputFieldForRealEstate = (titleId = '#name',slugId = '#slug',dropdownId,postTypeId) => {
    function setSlug(postTypeId,value){
        let slug = slugify(value)


        if (postTypeId == 5){
            if(slug && slug.length && !slug.includes('virgin-islands')){
                slug = 'virgin-islands-'+slug;
            }
        }else{
            if(slug && slug.length && !slug.includes('caribbean')) {
                slug = 'caribbean-' + slug;
            }
        }
        $(slugId).val(slug);
        $(titleId).val(sanitizeTitle(value));
    }

    $(titleId).on('input',function (e){
        value = $(this).val();
        setSlug(postTypeId,value);
    });

    $(dropdownId).on('select2:select',function (e){
        postTypeId = $(this).val();
        setSlug(postTypeId,$(titleId).val());

    });


}

