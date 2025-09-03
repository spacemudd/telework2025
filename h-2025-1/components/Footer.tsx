import { Building2, Mail, Phone, MapPin, Facebook, Twitter, Linkedin, Instagram } from "lucide-react";
import logo from "figma:asset/e4ad846ba572e83225e8a498f5b6ff15a80350c3.png";

export function Footer() {
  return (
    <footer style={{ backgroundColor: 'rgb(31, 41, 55)' }} className="text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Company Info */}
          <div className="space-y-4">
            <div className="flex items-center">
              <img 
                src={logo} 
                alt="هدف لخدمات الموارد البشرية" 
                className="h-14 w-auto brightness-0 invert"
              />
            </div>
            <p className="text-gray-300 leading-relaxed">
              نحن وكالة التوظيف الرائدة في المملكة العربية السعودية، نساعد الشركات على العثور على أفضل المواهب ونساعد الباحثين عن العمل في العثور على الوظائف المناسبة.
            </p>
            <div className="flex space-x-4 space-x-reverse">
              <a href="#" className="text-gray-300 hover:text-white transition-colors">
                <Facebook className="h-5 w-5" />
              </a>
              <a href="#" className="text-gray-300 hover:text-white transition-colors">
                <Twitter className="h-5 w-5" />
              </a>
              <a href="#" className="text-gray-300 hover:text-white transition-colors">
                <Linkedin className="h-5 w-5" />
              </a>
              <a href="#" className="text-gray-300 hover:text-white transition-colors">
                <Instagram className="h-5 w-5" />
              </a>
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="text-lg font-bold mb-4">روابط سريعة</h4>
            <ul className="space-y-2">
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">الصفحة الرئيسية</a></li>
              <li><a href="#jobs" className="text-gray-300 hover:text-white transition-colors">الوظائف</a></li>
              <li><a href="#companies" className="text-gray-300 hover:text-white transition-colors">للشركات</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">عن الشركة</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">المدونة</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">اتصل بنا</a></li>
            </ul>
          </div>

          {/* Job Categories */}
          <div>
            <h4 className="text-lg font-bold mb-4">فئات الوظائف</h4>
            <ul className="space-y-2">
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">التكنولوجيا</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">المالية</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">الرعاية الصحية</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">التعليم</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">الهندسة</a></li>
              <li><a href="#" className="text-gray-300 hover:text-white transition-colors">التسويق</a></li>
            </ul>
          </div>

          {/* Contact Info */}
          <div>
            <h4 className="text-lg font-bold mb-4">معلومات الاتصال</h4>
            <div className="space-y-3">
              <div className="flex items-center space-x-3 space-x-reverse">
                <Phone className="h-5 w-5 text-gray-300" />
                <span className="text-gray-300">+966 11 123 4567</span>
              </div>
              <div className="flex items-center space-x-3 space-x-reverse">
                <Mail className="h-5 w-5 text-gray-300" />
                <span className="text-gray-300">info@jobs-pro.sa</span>
              </div>
              <div className="flex items-start space-x-3 space-x-reverse">
                <MapPin className="h-5 w-5 text-gray-300 mt-1" />
                <span className="text-gray-300">
                  الرياض، المملكة العربية السعودية<br />
                  طريق الملك فهد، حي العليا
                </span>
              </div>
            </div>
          </div>
        </div>

        <hr className="my-8 border-gray-600" />

        <div className="flex flex-col md:flex-row justify-between items-center">
          <p className="text-gray-300 text-sm mb-4 md:mb-0">
            © 2024 هدف لخدمات الموارد البشرية. جميع الحقوق محفوظة.
          </p>
          <div className="flex space-x-6 space-x-reverse text-sm">
            <a href="#" className="text-gray-300 hover:text-white transition-colors">سياسة الخصوصية</a>
            <a href="#" className="text-gray-300 hover:text-white transition-colors">شروط الاستخدام</a>
            <a href="#" className="text-gray-300 hover:text-white transition-colors">ملفات تعريف الارتباط</a>
          </div>
        </div>
      </div>
    </footer>
  );
}