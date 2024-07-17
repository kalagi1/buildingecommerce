import React from 'react'
function EndSection(props) {
    return(
        <div>
            <div className="fourth-area">
                <div className="row" style={{justifyContent:'center'}}>
                    <div className="col-md-5">
                        <div className="finish-area">
                            <div className="icon"><i className="fa fa-thumbs-up"></i></div>
                            <div className="text">Başarıyla ilan eklediniz</div>
                            <div className="text">
                                <a href="/hesabim/react_projects" className="btn btn-info">Mağazama Git</a>
                                <a href="/hesabim/proje-ilani-ekle" className="btn btn-info mx-2">Yeni Proje Ekle</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
export default EndSection