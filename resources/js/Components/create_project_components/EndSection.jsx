import React from 'react'
function EndSection2(props) {
    return(
        <div>
      <div className="card single homes-content details mb-30 mt-5">
        <div className="row" style={{ justifyContent: "center" }}>
          <div
            className="col-md-5"
            style={{
              display: "flex",
              justifyContent: "center",
              alignItems: "center",
              margin: "0 auto",
            }}
          >
            <div className="finish-area">
              <div
                className="icon"
                style={{
                  display: "flex",
                  justifyContent: "center",
                  alignItems: "center",
                  margin: "0 auto",
                }}
              >
                <img
                  src="/green_double_circle_check_mark.jpg"
                  alt="Başarı İkonu"
                  style={{ width: "50px", height: "50px" }}
                />
              </div>
              <div className="text mb-3" style={{ textAlign: "center" }}>
                Başarıyla ilan eklediniz
              </div>
              <div className="text">
                <a href="/hesabim/proje-ilanlarim" className="btn btn-info">
                  Mağazama Git
                </a>
                <a
                  href="/hesabim/proje-ilani-ekle"
                  className="btn btn-info mx-2"
                >
                  Yeni Ücretsiz İlan Ver
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    )
}
export default EndSection2