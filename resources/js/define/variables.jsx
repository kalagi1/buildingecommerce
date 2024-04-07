export const baseUrl = "http://127.0.0.1:8000/react/";
export const frontEndUrl = "http://127.0.0.1:8000/";

export const dotNumberFormat = (number) => {
    if(number){
        if(number.replace('.','').replace('.','').replace('.','').replace('.','') != parseInt(number.replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
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