export const baseUrl = "https://emlaksepette.com/react/";
export const frontEndUrl = "https://emlaksepette.com/";

export const dotNumberFormat = (number) => {
    if(number){
        if(number?.replace('.','').replace('.','').replace('.','').replace('.','') != parseInt(number?.replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
            return "";
            
        }else{
            var inputValue = number.replace(/\D/g, '');
            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
            return inputValue;
        }
    }else{
        return "";
    }
    
}

