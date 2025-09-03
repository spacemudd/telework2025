import { Button } from "./ui/button";
import { Input } from "./ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "./ui/select";
import { Search, MapPin, Briefcase } from "lucide-react";

export function Hero() {
  return (
    <section className="py-20 px-4">
      <div className="max-w-4xl mx-auto text-center">
        <h1 className="text-4xl md:text-6xl font-bold text-white mb-6">
          اعثر على وظيفة أحلامك
        </h1>
        <p className="text-xl text-gray-300 mb-12 max-w-2xl mx-auto">
          نصل بين أفضل المواهب والشركات الرائدة في المنطقة. ابدأ رحلتك المهنية معنا اليوم
        </p>

        {/* Search Form */}
        <div className="bg-white rounded-lg shadow-lg p-6 mb-8 max-w-4xl mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div className="relative">
              <Search className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
              <Input 
                placeholder="البحث عن وظيفة..." 
                className="pr-10 text-right"
              />
            </div>
            
            <Select>
              <SelectTrigger className="text-right">
                <SelectValue placeholder="المدينة" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="riyadh">الرياض</SelectItem>
                <SelectItem value="jeddah">جدة</SelectItem>
                <SelectItem value="dammam">الدمام</SelectItem>
                <SelectItem value="makkah">مكة المكرمة</SelectItem>
                <SelectItem value="medina">المدينة المنورة</SelectItem>
              </SelectContent>
            </Select>

            <Select>
              <SelectTrigger className="text-right">
                <SelectValue placeholder="المجال" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="technology">التكنولوجيا</SelectItem>
                <SelectItem value="finance">المالية</SelectItem>
                <SelectItem value="healthcare">الرعاية الصحية</SelectItem>
                <SelectItem value="education">التعليم</SelectItem>
                <SelectItem value="engineering">الهندسة</SelectItem>
              </SelectContent>
            </Select>

            <Button className="w-full" style={{ backgroundColor: 'rgb(31, 41, 55)' }}>
              <Search className="h-4 w-4 ml-2" />
              بحث
            </Button>
          </div>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
          <div className="text-center">
            <h3 className="text-3xl font-bold mb-2">+5000</h3>
            <p className="text-gray-300">وظيفة متاحة</p>
          </div>
          <div className="text-center">
            <h3 className="text-3xl font-bold mb-2">+200</h3>
            <p className="text-gray-300">شركة معتمدة</p>
          </div>
          <div className="text-center">
            <h3 className="text-3xl font-bold mb-2">+10000</h3>
            <p className="text-gray-300">موظف تم توظيفهم</p>
          </div>
        </div>
      </div>
    </section>
  );
}