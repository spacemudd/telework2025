import { Button } from "./ui/button";
import { Search, Menu, User, Building2 } from "lucide-react";
import logo from "figma:asset/e4ad846ba572e83225e8a498f5b6ff15a80350c3.png";

export function Header() {
  return (
    <header className="bg-white shadow-sm border-b border-gray-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          {/* Logo and Brand */}
          <div className="flex items-center space-x-4 space-x-reverse">
            <div className="flex items-center">
              <img 
                src={logo} 
                alt="هدف لخدمات الموارد البشرية" 
                className="h-12 w-auto"
              />
            </div>
          </div>

          {/* Navigation Links - Desktop */}
          <nav className="hidden md:flex items-center space-x-8 space-x-reverse">
            <a href="#" className="text-gray-700 hover:text-gray-900 transition-colors">الرئيسية</a>
            <a href="#jobs" className="text-gray-700 hover:text-gray-900 transition-colors">الوظائف</a>
            <a href="#companies" className="text-gray-700 hover:text-gray-900 transition-colors">الشركات</a>
            <a href="#" className="text-gray-700 hover:text-gray-900 transition-colors">عن الشركة</a>
            <a href="#" className="text-gray-700 hover:text-gray-900 transition-colors">اتصل بنا</a>
          </nav>

          {/* Action Buttons */}
          <div className="flex items-center space-x-4 space-x-reverse">
            <Button variant="outline" size="sm" className="hidden sm:flex">
              <User className="h-4 w-4 ml-2" />
              تسجيل الدخول
            </Button>
            <Button size="sm" style={{ backgroundColor: 'rgb(31, 41, 55)' }} className="text-white hover:opacity-90">
              إنشاء حساب
            </Button>
            <Button variant="ghost" size="sm" className="md:hidden">
              <Menu className="h-5 w-5" />
            </Button>
          </div>
        </div>
      </div>
    </header>
  );
}